<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    // Hanya user_id yang bisa diisi secara massal
    protected $fillable = ['user_id'];

     /**
     * Relasi dengan user yang memiliki keranjang ini.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi dengan item-item di dalam keranjang.
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
