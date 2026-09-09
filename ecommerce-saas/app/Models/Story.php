<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable = [
        'tenant_id',
        'store_name',
        'store_logo',
        'media_url',
        'caption',
        'cta_text',
        'cta_url',
        'whatsapp_number',
        'views_count',
        'duration_seconds',
        'is_active',
        'expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'views_count' => 'integer',
        'duration_seconds' => 'integer',
        'expires_at' => 'datetime',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where(function (Builder $q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            });
    }
}