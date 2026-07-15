<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    protected $fillable = ['user_id', 'phone', 'institute', 'class_name', 'department', 'semester', 'resume_path', 'skills'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
