<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    protected $fillable = [
        'student_id', 'title', 'personal_info', 'education', 
        'skills', 'projects', 'experience'
    ];

    protected $casts = [
        'personal_info' => 'array',
        'education' => 'array',
        'skills' => 'array',
        'projects' => 'array',
        'experience' => 'array'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
