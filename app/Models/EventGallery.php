<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventGallery extends Model
{
    protected $table = 'event_gallery';

    protected $fillable = ['event_id', 'image_path'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
