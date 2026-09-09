<?php

namespace App\Models;

use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

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
