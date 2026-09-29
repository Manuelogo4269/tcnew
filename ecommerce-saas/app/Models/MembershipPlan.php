<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class MembershipPlan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'duration_days',
        'visits_included',
        'points_multiplier',
        'perks_json',
        'badge_color',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'duration_days' => 'integer',
            'visits_included' => 'integer',
            'points_multiplier' => 'decimal:2',
            'perks_json' => 'array',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (MembershipPlan $plan) {
            if (empty($plan->slug)) {
                $plan->slug = Str::slug($plan->name);
            }
        });
    }

    public function customerMemberships(): HasMany
    {
        return $this->hasMany(CustomerMembership::class);
    }
}
