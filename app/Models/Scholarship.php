<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    protected $fillable = [
        'title', 'description', 'eligibility', 'amount', 
        'deadline', 'official_apply_link', 'category_id', 'is_published'
    ];

    protected $casts = [
        'deadline' => 'date',
        'is_published' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(ScholarshipBookmark::class);
    }
}
