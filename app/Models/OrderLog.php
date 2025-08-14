<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderLog extends Model
{
    /**
     * Disable updated_at and created_at timestamps.
     * The `timestamp` column will be manually managed by `useCurrent()`.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'timestamp',
        'actor_user_id',
        'event_type',
        'old_value',
        'new_value',
        'message',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'timestamp' => 'datetime',
    ];

    /**
     * Get the order that the log belongs to.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the user (actor) who performed the action.
     */
    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_user_id');
    }
    
    /**
     * Metode statis untuk membuat entri log baru.
     *
     * @param array $data
     * @return OrderLog
     */
    public static function log(array $data)
    {
        // Gabungkan data yang diberikan dengan timestamp saat ini
        $logData = array_merge([
            'timestamp' => now(), // Atau Anda bisa mengandalkan created_at
        ], $data);

        return static::create($logData);
    }
}
