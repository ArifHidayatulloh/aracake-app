<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryMethod extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'method_name',
        'description',
        'base_cost',
        'cost_per_km',
        'is_pickup',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'base_cost' => 'decimal:2',
        'cost_per_km' => 'decimal:2',
        'is_pickup' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the orders that use this delivery method.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
