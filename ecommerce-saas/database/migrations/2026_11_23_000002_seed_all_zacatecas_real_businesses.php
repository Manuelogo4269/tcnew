<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Tenant;

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
            // Log or ignore gracefully
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
