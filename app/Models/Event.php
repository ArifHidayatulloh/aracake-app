<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = ['id'];

    public function products(){
        return $this->hasMany(EventProduct::class, 'event_id');
    }
}
