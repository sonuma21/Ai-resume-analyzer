<?php

use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;

Route::get('/resume', [ResumeController::class, 'index'])->name('resume.index');
Route::post('/resume/analyze', [ResumeController::class, 'analyze'])->name('resume.analyze');


