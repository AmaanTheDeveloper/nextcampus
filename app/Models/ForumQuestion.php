<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumQuestion extends Model
{
    protected $fillable = ['student_id', 'title', 'content', 'views'];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function answers()
    {
        return $this->hasMany(ForumAnswer::class, 'question_id');
    }
}
