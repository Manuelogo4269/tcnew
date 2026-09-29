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
        // 1. Membership Plans Table (B2C business offering)
        if (!Schema::hasTable('membership_plans')) {
            Schema::create('membership_plans', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // e.g. Pase Mensual VIP, Club Oro, Paquete 10 Sesiones
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->decimal('price', 10, 2);
                $table->integer('duration_days')->default(30); // 30, 90, 365 days
                $table->integer('visits_included')->default(0); // 0 = unlimited, >0 = bundle visits
                $table->decimal('points_multiplier', 4, 2)->default(1.00); // 1.5x points per dollar
                $table->json('perks_json')->nullable(); // Bullet list of benefits
                $table->string('badge_color')->default('#d96b45');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // 2. Customer Memberships (Digital membership cards)
        if (!Schema::hasTable('customer_memberships')) {
            Schema::create('customer_memberships', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tenant_user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('customer_account_id')->nullable()->index(); // Link to central mobile customer
                $table->string('customer_name');
                $table->string('customer_email')->index();
                $table->string('customer_phone')->nullable();
                $table->foreignId('membership_plan_id')->constrained('membership_plans')->cascadeOnDelete();
                $table->string('membership_code')->unique(); // e.g. MEM-7X9Q2
                $table->date('start_date');
                $table->date('end_date');
                $table->string('status')->default('active'); // active, expired, cancelled, suspended
                $table->integer('visits_used')->default(0);
                $table->integer('accumulated_points')->default(0);
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // 3. Customer Membership Logs (Visits & Points History)
        if (!Schema::hasTable('customer_membership_logs')) {
            Schema::create('customer_membership_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('customer_membership_id')->constrained('customer_memberships')->cascadeOnDelete();
                $table->string('type')->default('visit'); // visit, points_added, points_redeemed, renewal
                $table->integer('points_delta')->default(0);
                $table->string('description');
                $table->dateTime('performed_at');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_membership_logs');
        Schema::dropIfExists('customer_memberships');
        Schema::dropIfExists('membership_plans');
    }
};
