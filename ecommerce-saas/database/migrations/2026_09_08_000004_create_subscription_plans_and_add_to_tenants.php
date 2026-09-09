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
        if (!Schema::hasTable('subscription_plans')) {
            Schema::create('subscription_plans', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // e.g. "Plan Emprendedor"
                $table->string('slug')->unique(); // e.g. "emprendedor"
                $table->string('badge')->nullable(); // e.g. "Más Popular"
                $table->string('tagline')->nullable();
                $table->decimal('monthly_price', 10, 2)->default(0);
                $table->decimal('annual_price_per_month', 10, 2)->default(0); // discounted monthly price when paid annually
                $table->integer('annual_discount_percentage')->default(20);
                $table->string('currency')->default('USD');
                $table->integer('product_limit')->nullable(); // null = unlimited
                $table->boolean('has_custom_domain')->default(false);
                $table->boolean('has_priority_support')->default(false);
                $table->boolean('has_analytics')->default(false);
                $table->boolean('has_api_access')->default(false);
                $table->json('features')->nullable(); // bullet points
                $table->boolean('is_popular')->default(false);
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }

        Schema::table('tenants', function (Blueprint $table) {
            if (!Schema::hasColumn('tenants', 'plan_name')) {
                $table->string('plan_name')->default('Emprendedor')->after('data');
            }
            if (!Schema::hasColumn('tenants', 'billing_cycle')) {
                $table->string('billing_cycle')->default('monthly')->after('plan_name'); // 'monthly', 'annual'
            }
            if (!Schema::hasColumn('tenants', 'subscription_status')) {
                $table->string('subscription_status')->default('active')->after('billing_cycle'); // 'active', 'trial', 'past_due', 'cancelled'
            }
            if (!Schema::hasColumn('tenants', 'subscription_amount')) {
                $table->decimal('subscription_amount', 10, 2)->nullable()->after('subscription_status');
            }
            if (!Schema::hasColumn('tenants', 'subscription_ends_at')) {
                $table->dateTime('subscription_ends_at')->nullable()->after('subscription_amount');
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
                'plan_name',
                'billing_cycle',
                'subscription_status',
                'subscription_amount',
                'subscription_ends_at',
            ]);
        });

        Schema::dropIfExists('subscription_plans');
    }
};
