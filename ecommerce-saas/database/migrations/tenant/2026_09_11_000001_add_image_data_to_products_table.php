<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('products', 'image_data')) {
            Schema::table('products', function (Blueprint $table) {
                $table->longText('image_data')->nullable()->after('image_url');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('products', 'image_data')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('image_data');
            });
        }
    }
};
