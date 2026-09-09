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
        Schema::table('tenants', function (Blueprint $table) {
            if (!Schema::hasColumn('tenants', 'address')) {
                $table->string('address')->nullable()->after('subscription_ends_at');
            }
            if (!Schema::hasColumn('tenants', 'neighborhood_zone')) {
                $table->string('neighborhood_zone')->nullable()->default('Centro Histórico')->after('address');
            }
            if (!Schema::hasColumn('tenants', 'city')) {
                $table->string('city')->nullable()->default('Zacatecas')->after('neighborhood_zone');
            }
            if (!Schema::hasColumn('tenants', 'latitude')) {
                $table->decimal('latitude', 10, 7)->nullable()->after('city');
            }
            if (!Schema::hasColumn('tenants', 'longitude')) {
                $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            }
            if (!Schema::hasColumn('tenants', 'maps_url')) {
                $table->text('maps_url')->nullable()->after('longitude');
            }
            if (!Schema::hasColumn('tenants', 'opening_hours')) {
                $table->string('opening_hours')->nullable()->default('Lunes a Sábado: 10:00 AM - 8:30 PM')->after('maps_url');
            }
            if (!Schema::hasColumn('tenants', 'location_reference')) {
                $table->string('location_reference')->nullable()->after('opening_hours');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
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
