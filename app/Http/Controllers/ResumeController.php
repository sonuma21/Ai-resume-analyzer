<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser as PdfParser;
use PhpOffice\PhpWord\IOFactory;

class ResumeController extends Controller
{
    /**
     * Show the resume upload form.
     */
    public function index()
    {
        return view('resume.index');
    }

    /**
     * Handle the resume and job description input, validate data, and extract text.
     */
    public function analyze(Request $request)
    {
        // Validate incoming data
        $request->validate([
            'resume' => 'required|file|mimes:txt,pdf,doc,docx|max:5120', // Max 5MB file size
            'job_description' => 'required|string', // Validate that job description is a string
        ]);

        try {
            // Extract text from the uploaded resume
            $resumeText = $this->extractTextFromFile($request->file('resume'));
            $jobDescription = $request->input('job_description'); // Get the job description from the form

            // Log the extracted text for testing (remove or comment out in production)
            Log::info('Extracted resume text: ' . substr($resumeText, 0, 200) . '...'); // Log first 200 chars

            // Temporary response for testing extraction (replace with OpenAI call in Day 5)
            return response()->json([
                'message' => 'Text extraction successful',
                'resume_preview' => substr($resumeText, 0, 300), // Preview first 300 chars
                'job_description' => $jobDescription,
                'file_name' => $request->file('resume')->getClientOriginalName(),
            ]);
        } catch (\Exception $e) {
            // Log error and return error response
            Log::error('Error in analyze: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to process resume: ' . $e->getMessage()], 400);
        }
    }

    /**
     * Private method to extract text from uploaded file.
     */
    private function extractTextFromFile($file)
    {
        $extension = strtolower($file->getClientOriginalExtension());

        if (!in_array($extension, ['txt', 'pdf', 'doc', 'docx'])) {
            throw new \Exception("Unsupported file type: {$extension}");
        }

        try {
            // Handle TXT files
            if ($extension === 'txt') {
                return file_get_contents($file->getPathname());
            }

            // Handle PDFs
            elseif ($extension === 'pdf') {
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($file->getPathname());
                return $pdf->getText() ?: '';
            }

            // Handle DOC / DOCX
            elseif (in_array($extension, ['doc', 'docx'])) {
                $phpWord = \PhpOffice\PhpWord\IOFactory::load($file->getPathname());
                $text = '';

                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        // Extract plain text
                        if ($element instanceof \PhpOffice\PhpWord\Element\Text) {
                            $text .= $element->getText() . "\n";
                        }
                        // Extract text inside paragraphs
                        elseif ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
                            foreach ($element->getElements() as $child) {
                                if ($child instanceof \PhpOffice\PhpWord\Element\Text) {
                                    $text .= $child->getText() . "\n";
                                }
                            }
                        }
                        // Extract table content
                        elseif ($element instanceof \PhpOffice\PhpWord\Element\Table) {
                            foreach ($element->getRows() as $row) {
                                foreach ($row->getCells() as $cell) {
                                    foreach ($cell->getElements() as $cellElement) {
                                        if ($cellElement instanceof \PhpOffice\PhpWord\Element\Text) {
                                            $text .= $cellElement->getText() . "\t";
                                        }
                                    }
                                }
                                $text .= "\n";
                            }
                        }
                    }
                }

                return trim($text) ?: '';
            }

            return '';
        } catch (\Exception $e) {
            Log::error('Error extracting text from file ' . $file->getClientOriginalName() . ': ' . $e->getMessage());
            throw new \Exception("Error extracting text from file: " . $e->getMessage());
        }
    }
}
