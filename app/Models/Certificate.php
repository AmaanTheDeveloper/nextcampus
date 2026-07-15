<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = ['student_id', 'title', 'category', 'file_path', 'issue_date'];

    protected $casts = [
        'issue_date' => 'date'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
