<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    protected $fillable = ['user_id', 'phone', 'institute', 'class_name', 'department', 'semester', 'resume_path', 'skills', 'portfolio_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCompletionPercentageAttribute()
    {
        $fields = [
            $this->user->name,
            $this->user->phone ?? $this->phone,
            $this->institute,
            $this->department,
            $this->semester,
            $this->skills,
            $this->resume_path,
            $this->portfolio_url,
            $this->user->github,
            $this->user->linkedin
        ];

        $completed = 0;
        foreach ($fields as $field) {
            if (!empty($field)) {
                $completed++;
            }
        }

        return round(($completed / count($fields)) * 100);
    }
}
