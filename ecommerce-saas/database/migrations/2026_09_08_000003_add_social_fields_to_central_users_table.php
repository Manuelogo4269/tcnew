<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $conn = config('tenancy.database.central_connection', config('database.default'));
        if (Schema::connection($conn)->hasTable('users')) {
            Schema::connection($conn)->table('users', function (Blueprint $table) use ($conn) {
                if (!Schema::connection($conn)->hasColumn('users', 'auth_provider')) {
                    $table->string('auth_provider')->default('email')->after('password');
                }
                if (!Schema::connection($conn)->hasColumn('users', 'auth_provider_id')) {
                    $table->string('auth_provider_id')->nullable()->after('auth_provider');
                }
                if (!Schema::connection($conn)->hasColumn('users', 'avatar_url')) {
                    $table->string('avatar_url')->nullable()->after('auth_provider_id');
                }
            });
        }
    }

    public function down(): void
    {
        $conn = config('tenancy.database.central_connection', config('database.default'));
        if (Schema::connection($conn)->hasTable('users')) {
            Schema::connection($conn)->table('users', function (Blueprint $table) use ($conn) {
                $colsToDrop = array_filter(['auth_provider', 'auth_provider_id', 'avatar_url'], fn($c) => Schema::connection($conn)->hasColumn('users', $c));
                if (!empty($colsToDrop)) {
                    $table->dropColumn($colsToDrop);
                }
            });
        }
    }
};
