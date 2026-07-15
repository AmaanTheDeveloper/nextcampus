<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    protected $fillable = [
        'company_id', 'category_id', 'title', 'description', 'requirements', 
        'skills', 'location', 'salary', 'deadline', 'status', 'approval_status', 'is_published'
    ];

    protected $casts = [
        'deadline' => 'date',
        'is_published' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function company()
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    public function applications()
    {
        return $this->hasMany(InternshipApplication::class);
    }
}
