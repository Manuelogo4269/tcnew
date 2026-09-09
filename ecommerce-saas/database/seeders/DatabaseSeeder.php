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

        // 2. Global Customers (for Marketplace & Sanctum App Mobile)
        CustomerAccount::updateOrCreate(
            ['email' => 'juan@gmail.com'],
            [
                'name' => 'Juan Pérez (Cliente Local Centro)',
                'password' => Hash::make('password123'),
            ]
        );

        CustomerAccount::updateOrCreate(
            ['email' => 'maria@gmail.com'],
            [
                'name' => 'María Fernández (Compradora Frecuente)',
                'password' => Hash::make('password123'),
            ]
        );

        CustomerAccount::updateOrCreate(
            ['email' => 'turista@gmail.com'],
            [
                'name' => 'Alejandro Ruiz (Turista Zacatecas)',
                'password' => Hash::make('password123'),
            ]
        );

        // 3. Subscription Plans
        $this->call(SubscriptionPlanSeeder::class);

        // 4. Real Iconic Zacatecas Centro Businesses
        $this->call(ZacatecasRealBusinessesSeeder::class);

        // 5. Customer Reviews & Ratings (1 to 5 stars)
        $this->call(ReviewSeeder::class);
    }
}
