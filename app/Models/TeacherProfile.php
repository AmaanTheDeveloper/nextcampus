<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherProfile extends Model
{
    protected $fillable = ['user_id', 'department', 'designation'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
