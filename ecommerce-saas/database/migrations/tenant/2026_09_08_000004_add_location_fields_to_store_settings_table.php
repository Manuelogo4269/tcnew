<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('store_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('store_settings', 'address')) {
                $table->string('address')->nullable()->after('business_category');
            }
            if (!Schema::hasColumn('store_settings', 'neighborhood_zone')) {
                $table->string('neighborhood_zone')->nullable()->default('Centro Histórico')->after('address');
            }
            if (!Schema::hasColumn('store_settings', 'city')) {
                $table->string('city')->nullable()->default('Zacatecas')->after('neighborhood_zone');
            }
            if (!Schema::hasColumn('store_settings', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable()->after('city');
            }
            if (!Schema::hasColumn('store_settings', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            }
            if (!Schema::hasColumn('store_settings', 'maps_url')) {
                $table->text('maps_url')->nullable()->after('longitude');
            }
            if (!Schema::hasColumn('store_settings', 'opening_hours')) {
                $table->string('opening_hours')->nullable()->default('Lunes a Sábado: 10:00 AM - 8:30 PM')->after('maps_url');
            }
            if (!Schema::hasColumn('store_settings', 'location_reference')) {
                $table->string('location_reference')->nullable()->after('opening_hours');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('store_settings', function (Blueprint $table) {
            $table->dropColumn([
                'address',
                'neighborhood_zone',
                'city',
                'latitude',
                'longitude',
                'maps_url',
                'opening_hours',
                'location_reference',
            ]);
        });
    }
};
