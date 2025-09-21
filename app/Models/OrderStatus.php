<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderStatus extends Model
{
    use HasFactory;
    /* The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'status_name',
        'order',
        'description',
        'status_color',
        'is_active',
    ];

    /**
     * Get the orders that have this status.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'order_status_id');
    }
}
