<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class analyzer extends Model
{
     protected $fillable = [
           'user_id',
           'resume_text',
           'job_desc',
           'match_score',
           'feedback',
       ];

       protected $casts = [
           'feedback' => 'array', // Automatically decode JSON to array
       ];
}
