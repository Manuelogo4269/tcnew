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
        // 1. Staff / Professionals Table
        if (!Schema::hasTable('staff')) {
            Schema::create('staff', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('role')->default('Especialista'); // e.g. Estilista, Barbero, Terapeuta, etc.
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->text('bio')->nullable();
                $table->string('photo_url')->nullable();
                $table->json('schedule_json')->nullable(); // Working hours / days
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // 2. Extend Products with Service fields
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'is_service')) {
                $table->boolean('is_service')->default(false)->after('is_active');
            }
            if (!Schema::hasColumn('products', 'duration_minutes')) {
                $table->integer('duration_minutes')->default(30)->after('is_service');
            }
        });

        // 3. Pivot Staff - Services
        if (!Schema::hasTable('staff_service')) {
            Schema::create('staff_service', function (Blueprint $table) {
                $table->foreignId('staff_id')->constrained('staff')->cascadeOnDelete();
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->primary(['staff_id', 'product_id']);
            });
        }

        // 4. Appointments / Agenda Table
        if (!Schema::hasTable('appointments')) {
            Schema::create('appointments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('customer_name');
                $table->string('customer_email')->nullable();
                $table->string('customer_phone');
                $table->foreignId('staff_id')->constrained('staff')->cascadeOnDelete();
                $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
                $table->string('service_name');
                $table->dateTime('scheduled_at');
                $table->dateTime('end_at');
                $table->integer('duration_minutes')->default(30);
                $table->decimal('price', 10, 2)->default(0.00);
                $table->string('status')->default('confirmed'); // pending, confirmed, in_service, completed, cancelled
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
        Schema::dropIfExists('staff_service');

        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'duration_minutes')) {
                $table->dropColumn('duration_minutes');
            }
            if (Schema::hasColumn('products', 'is_service')) {
                $table->dropColumn('is_service');
            }
        });

        Schema::dropIfExists('staff');
    }
};
