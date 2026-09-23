<?php

namespace App\Models;

use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    protected $attributes = [
        'plan_name' => 'Emprendedor',
        'billing_cycle' => 'monthly',
        'subscription_status' => 'active',
    ];

    public function hasActiveSubscription(): bool
    {
        $validPlans = ['Emprendedor', 'Crecimiento', 'Corporativo'];
        $cleanPlan = trim(str_replace('Plan ', '', (string) ($this->plan_name ?? '')));
        $hasValidPlan = in_array($cleanPlan, $validPlans, true) || in_array($this->plan_name, $validPlans, true);

        $status = strtolower((string) ($this->subscription_status ?? ''));
        $isActiveStatus = in_array($status, ['active', 'trial'], true);

        $notExpired = empty($this->subscription_ends_at) || \Carbon\Carbon::parse($this->subscription_ends_at)->isFuture();

        return $hasValidPlan && $isActiveStatus && $notExpired;
    }

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'plan_name',
            'billing_cycle',
            'subscription_status',
            'subscription_amount',
            'subscription_ends_at',
            'address',
            'neighborhood_zone',
            'city',
            'latitude',
            'longitude',
            'maps_url',
            'opening_hours',
            'location_reference',
            'created_at',
            'updated_at',
        ];
    }
}
