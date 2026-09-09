<?php

namespace Database\Seeders;

use App\Models\CentralUser;
use App\Models\CustomerAccount;
use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's central and tenant databases.
     */
    public function run(): void
    {
        // 1. Central Super Administrator (for /admin panel)
        CentralUser::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrador SaaS',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Global Mobile Customer (for Sanctum App Mobile)
        $globalCustomer = CustomerAccount::updateOrCreate(
            ['email' => 'juan@gmail.com'],
            [
                'name' => 'Juan Pérez',
                'password' => Hash::make('password'),
            ]
        );

        // 3. Subscription Plans
        $this->call(SubscriptionPlanSeeder::class);

        // 4. Real Iconic Zacatecas Centro Businesses
        $this->call(ZacatecasRealBusinessesSeeder::class);
    }
}
