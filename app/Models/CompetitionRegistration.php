<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompetitionRegistration extends Model
{
    protected $fillable = ['competition_id', 'student_id', 'status'];

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
