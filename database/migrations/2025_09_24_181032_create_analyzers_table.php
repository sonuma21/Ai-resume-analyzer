<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('analyzers', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->text('resume_text'); // Stores the extracted resume text
            $table->text('job_desc'); // Stores the job description text
            $table->unsignedTinyInteger('match_score')->nullable(); // Match score (0-100)
            $table->json('feedback')->nullable(); // JSON field for AI feedback (e.g., missing keywords, improved bullets)
            $table->timestamps(); // Created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyzers');
    }
};
