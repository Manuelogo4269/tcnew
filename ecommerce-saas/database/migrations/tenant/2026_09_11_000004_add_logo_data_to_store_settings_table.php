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
        if (!Schema::hasColumn('store_settings', 'logo_data')) {
            Schema::table('store_settings', function (Blueprint $table) {
                $table->longText('logo_data')->nullable()->after('logo_url');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('store_settings', 'logo_data')) {
            Schema::table('store_settings', function (Blueprint $table) {
                $table->dropColumn('logo_data');
            });
        }
    }
};
