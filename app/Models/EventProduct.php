<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventProduct extends Model
{
    protected $guarded = ['id'];

    public function event(){
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
