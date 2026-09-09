<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $connection = 'central';

    protected $fillable = [
        'name',
        'slug',
        'badge',
        'tagline',
        'monthly_price',
        'annual_price_per_month',
        'annual_discount_percentage',
        'currency',
        'product_limit',
        'has_custom_domain',
        'has_priority_support',
        'has_analytics',
        'has_api_access',
        'features',
        'is_popular',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'monthly_price' => 'decimal:2',
        'annual_price_per_month' => 'decimal:2',
        'annual_discount_percentage' => 'integer',
        'product_limit' => 'integer',
        'has_custom_domain' => 'boolean',
        'has_priority_support' => 'boolean',
        'has_analytics' => 'boolean',
        'has_api_access' => 'boolean',
        'features' => 'array',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get total billed amount for an annual subscription (12 months)
     */
    public function getAnnualTotalAttribute(): float
    {
        return round((float) $this->annual_price_per_month * 12, 2);
    }

    /**
     * Get annual savings amount compared to 12 monthly payments
     */
    public function getAnnualSavingsAttribute(): float
    {
        $yearlyMonthly = (float) $this->monthly_price * 12;
        $yearlyAnnual = $this->annual_total;
        return max(0, round($yearlyMonthly - $yearlyAnnual, 2));
    }
}
