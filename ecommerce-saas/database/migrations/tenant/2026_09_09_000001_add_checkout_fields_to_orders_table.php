<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'folio')) {
                    $table->string('folio')->nullable()->index();
                }
                if (!Schema::hasColumn('orders', 'customer_name')) {
                    $table->string('customer_name')->nullable();
                }
                if (!Schema::hasColumn('orders', 'customer_email')) {
                    $table->string('customer_email')->nullable();
                }
                if (!Schema::hasColumn('orders', 'customer_phone')) {
                    $table->string('customer_phone')->nullable();
                }
                if (!Schema::hasColumn('orders', 'payment_method')) {
                    $table->string('payment_method')->default('efectivo');
                }
                if (!Schema::hasColumn('orders', 'payment_status')) {
                    $table->string('payment_status')->default('pending');
                }
                if (!Schema::hasColumn('orders', 'order_notes')) {
                    $table->text('order_notes')->nullable();
                }
            });
        }

        if (Schema::hasTable('order_items')) {
            Schema::table('order_items', function (Blueprint $table) {
                if (!Schema::hasColumn('order_items', 'product_name')) {
                    $table->string('product_name')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        // No-op
    }
};
