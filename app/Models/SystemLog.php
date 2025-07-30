<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class SystemLog extends Model
{
    /**
     * Disable updated_at and created_at timestamps.
     * The `timestamp` column will be manually managed by `useCurrent()` in migration.
     *
     * @var bool
     */
    public $timestamps = false; // Karena kita menggunakan `timestamp` dan bukan `created_at`/`updated_at`

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'timestamp',
        'log_level',
        'event_type',
        'message',
        'user_id',
        'ip_address',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'timestamp' => 'datetime',
        'metadata' => 'array', // Casting JSON ke array/object PHP
        'log_level' => \App\Enums\LogLevel::class, // Opsional: jika Anda membuat Enum untuk LogLevel
    ];

    /**
     * Get the user that performed the action.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper static method to log an event.
     *
     * @param string $logLevel (e.g., 'INFO', 'WARN', 'ERROR', 'DEBUG')
     * @param string $eventType (e.g., 'CATEGORY_CREATED', 'PRODUCT_UPDATED', 'ORDER_STATUS_CHANGE')
     * @param string $message
     * @param array $metadata Optional additional data
     * @param int|null $userId Optional user ID, defaults to current authenticated user
     * @param string|null $ipAddress Optional IP address, defaults to current request IP
     * @return SystemLog
     */
    public static function log(
        string $logLevel,
        string $eventType,
        string $message,
        array $metadata = [],
        ?int $userId = null,
        ?string $ipAddress = null
    ): SystemLog {
        return self::create([
            'timestamp' => now(),
            'log_level' => $logLevel,
            'event_type' => $eventType,
            'message' => $message,
            'user_id' => $userId ?? (Auth::check() ? Auth::id() : null),
            'ip_address' => $ipAddress ?? request()->ip(),
            'metadata' => $metadata,
        ]);
    }
}
