<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title', 'description', 'type', 'location', 
        'event_date', 'registration_deadline', 'created_by',
        'category_id', 'approval_status', 'is_published',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'registration_deadline' => 'date',
        'is_published' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function gallery()
    {
        return $this->hasMany(EventGallery::class);
    }
}
