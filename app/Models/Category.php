<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'type'];

    public function competitions()
    {
        return $this->hasMany(Competition::class);
    }

    public function scholarships()
    {
        return $this->hasMany(Scholarship::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function internships()
    {
        return $this->hasMany(Internship::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
