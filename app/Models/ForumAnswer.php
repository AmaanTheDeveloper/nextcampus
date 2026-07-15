<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumAnswer extends Model
{
    protected $fillable = ['question_id', 'user_id', 'content'];

    public function question()
    {
        return $this->belongsTo(ForumQuestion::class, 'question_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
