<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'reviewable_type',
        'reviewable_id',
        'author_name',
        'rating',
        'comment',
        'verified_purchase',
        'is_approved',
    ];

    protected $casts = [
        'rating' => 'integer',
        'verified_purchase' => 'boolean',
        'is_approved' => 'boolean',
    ];

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('is_approved', true);
    }

    public function scopeForCompany(Builder $query, string $tenantId): Builder
    {
        return $query->where('reviewable_type', 'company')->where('reviewable_id', $tenantId);
    }

    public function scopeForProduct(Builder $query, string $productId): Builder
    {
        return $query->where('reviewable_type', 'product')->where('reviewable_id', $productId);
    }
}