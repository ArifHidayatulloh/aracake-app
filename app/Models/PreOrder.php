<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreOrder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'preorder_start_date',
        'preorder_end_date',
        'estimated_completion_date',
        'down_payment_required',
        'down_payment_amount',
        'final_payment_due_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'preorder_start_date' => 'date',
        'preorder_end_date' => 'date',
        'estimated_completion_date' => 'date',
        'down_payment_required' => 'boolean',
        'down_payment_amount' => 'decimal:2',
        'final_payment_due_date' => 'date',
    ];

    /**
     * Get the order that this pre-order details belong to.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
