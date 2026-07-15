<?php

namespace App\Models;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    protected $fillable = [
        'title', 'description', 'category_id', 'rules', 'prizes', 
        'registration_deadline', 'start_date', 'end_date', 'created_by', 'winners', 'is_published'
    ];

    protected $casts = [
        'registration_deadline' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_published' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function registrations()
    {
        return $this->hasMany(CompetitionRegistration::class);
    }
}
