<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            if (file_exists(database_path('seeders/ZacatecasRealBusinessesSeeder.php'))) {
                require_once database_path('seeders/ZacatecasRealBusinessesSeeder.php');
            }
            if (class_exists(\Database\Seeders\ZacatecasRealBusinessesSeeder::class)) {
                (new \Database\Seeders\ZacatecasRealBusinessesSeeder())->run();
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Reseed migration error: " . $e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
