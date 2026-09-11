<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'folio',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'payment_method',
        'payment_status',
        'status',
        'total_amount',
        'shipping_address',
        'order_notes',
        'stripe_session_id',
        'stripe_payment_intent_id',
    ];

    public static function generateFolio(string $prefix = 'ZAC'): string
    {
        return strtoupper($prefix) . '-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));
    }

    protected function casts(): array
    {
        return ['total_amount' => 'decimal:2'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(TenantUser::class, 'user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
