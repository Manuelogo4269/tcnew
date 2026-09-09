<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::connection('central')->table('users', function (Blueprint $table) {
            $table->string('auth_provider')->default('email')->after('password');
            $table->string('auth_provider_id')->nullable()->after('auth_provider');
            $table->string('avatar_url')->nullable()->after('auth_provider_id');
        });
    }

    public function down(): void
    {
        Schema::connection('central')->table('users', function (Blueprint $table) {
            $table->dropColumn(['auth_provider', 'auth_provider_id', 'avatar_url']);
        });
    }
};
