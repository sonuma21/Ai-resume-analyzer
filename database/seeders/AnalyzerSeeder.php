<?php

namespace Database\Seeders;

use App\Models\analyzer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnalyzerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $sampleData = [
            [
                'user_id' => 1, // Assumes a user with ID 1 exists in the users table
                'resume_text' => "John Doe\nSoftware Engineer\n- Developed web applications using Laravel and Vue.js\n- Improved API response time by 30%\n- Collaborated with a team of 5 developers\nSkills: PHP, JavaScript, MySQL",
                'job_desc' => "We are hiring a Software Engineer!\nResponsibilities:\n- Build and maintain scalable web applications\n- Optimize APIs for performance\n- Work in a team to deliver features\nRequirements: PHP, Laravel, JavaScript, MySQL, REST API, CI/CD",
                'match_score' => 85,
                'feedback' => json_encode([
                    'match_score' => 85,
                    'missing_keywords' => ['REST API', 'CI/CD'],
                    'improved_bullets' => [
                        'Developed and optimized web applications using Laravel and Vue.js, reducing API response time by 30%',
                        'Collaborated with a 5-member team to deliver robust features on schedule',
                    ],
                    'summary_comment' => 'Strong PHP and Laravel skills, but add REST API and CI/CD experience.'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // Assumes a user with ID 2 exists
                'resume_text' => "Jane Smith\nBackend Developer\n- Built RESTful APIs with Node.js\n- Managed databases with PostgreSQL\n- Automated deployments\nSkills: Node.js, PostgreSQL, Docker",
                'job_desc' => "Backend Developer Role\nResponsibilities:\n- Develop and maintain REST APIs\n- Optimize database performance\n- Implement CI/CD pipelines\nRequirements: Node.js, PostgreSQL, Docker, GraphQL",
                'match_score' => 78,
                'feedback' => json_encode([
                    'match_score' => 78,
                    'missing_keywords' => ['GraphQL'],
                    'improved_bullets' => [
                        'Designed and implemented RESTful APIs with Node.js, improving system scalability',
                        'Optimized PostgreSQL database queries, reducing latency by 25%',
                    ],
                    'summary_comment' => 'Solid backend skills, but include GraphQL to better align with job requirements.'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
         foreach ($sampleData as $data) {
            analyzer::create($data);
        }
    }
}
