<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'title', 'description', 'file_path', 'subject', 
        'semester', 'uploaded_by', 'category_id', 'downloads_count',
        'approval_status', 'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
