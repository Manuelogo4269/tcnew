<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'staff_id',
        'product_id',
        'service_name',
        'scheduled_at',
        'end_at',
        'duration_minutes',
        'price',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'end_at' => 'datetime',
            'duration_minutes' => 'integer',
            'price' => 'decimal:2',
        ];
    }

    public const STATUS_PENDING = 'pending';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_IN_SERVICE = 'in_service';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    public static function statusLabels(): array
    {
        return [
            self::STATUS_PENDING => 'Pendiente',
            self::STATUS_CONFIRMED => 'Confirmada',
            self::STATUS_IN_SERVICE => 'En Servicio',
            self::STATUS_COMPLETED => 'Completada',
            self::STATUS_CANCELLED => 'Cancelada',
        ];
    }

    public static function statusColors(): array
    {
        return [
            self::STATUS_PENDING => 'warning',
            self::STATUS_CONFIRMED => 'info',
            self::STATUS_IN_SERVICE => 'primary',
            self::STATUS_COMPLETED => 'success',
            self::STATUS_CANCELLED => 'danger',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(TenantUser::class, 'user_id');
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
