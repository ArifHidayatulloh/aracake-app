<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;
     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'no_transaction',
        'order_status_id',
        'delivery_method_id',
        'pickup_delivery_address_id',
        'order_date', // Pastikan ini dikelola atau gunakan default DB
        'pickup_delivery_date',
        'payment_method_id',
        'total_amount',
        'delivery_cost',
        'notes',
        'is_cancelled',
        'cancellation_reason',
        'is_finish'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'order_date' => 'datetime',
        'pickup_delivery_date' => 'date',
        'total_amount' => 'decimal:2',
        'delivery_cost' => 'decimal:2',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the status that belongs to the order.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    /**
     * Get the delivery method that belongs to the order.
     */
    public function deliveryMethod(): BelongsTo
    {
        return $this->belongsTo(DeliveryMethod::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Get the address used for pickup/delivery for the order.
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(UserAddress::class, 'pickup_delivery_address_id');
    }

    /**
     * Get the items for the order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the payment for the order.
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Get the pre-order details for the order.
     */
    public function preOrder(): HasOne
    {
        return $this->hasOne(PreOrder::class);
    }

    /**
     * Get the logs for the order.
     */
    public function logs(): HasMany
    {
        return $this->hasMany(OrderLog::class);
    }
}
