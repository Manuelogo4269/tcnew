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
        if (Schema::hasTable('store_settings')) {
            Schema::table('store_settings', function (Blueprint $table) {
                if (!Schema::hasColumn('store_settings', 'stripe_enabled')) {
                    $table->boolean('stripe_enabled')->default(true)->after('footer_text');
                }
                if (!Schema::hasColumn('store_settings', 'stripe_publishable_key')) {
                    $table->string('stripe_publishable_key')->nullable()->after('stripe_enabled');
                }
                if (!Schema::hasColumn('store_settings', 'stripe_secret_key')) {
                    $table->string('stripe_secret_key')->nullable()->after('stripe_publishable_key');
                }
            });
        }

        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'stripe_session_id')) {
                    $table->string('stripe_session_id')->nullable()->index()->after('payment_status');
                }
                if (!Schema::hasColumn('orders', 'stripe_payment_intent_id')) {
                    $table->string('stripe_payment_intent_id')->nullable()->after('stripe_session_id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('store_settings')) {
            Schema::table('store_settings', function (Blueprint $table) {
                $columns = array_filter(['stripe_enabled', 'stripe_publishable_key', 'stripe_secret_key'], function ($col) {
                    return Schema::hasColumn('store_settings', $col);
                });
                if (!empty($columns)) {
                    $table->dropColumn($columns);
                }
            });
        }

        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                $columns = array_filter(['stripe_session_id', 'stripe_payment_intent_id'], function ($col) {
                    return Schema::hasColumn('orders', $col);
                });
                if (!empty($columns)) {
                    $table->dropColumn($columns);
                }
            });
        }
    }
};
