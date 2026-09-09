<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable()->index();
            $table->string('store_name');
            $table->string('store_logo')->nullable();
            $table->string('media_url');
            $table->text('caption')->nullable();
            $table->string('cta_text')->default('Ver Tienda Oficial');
            $table->string('cta_url')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedSmallInteger('duration_seconds')->default(5);
            $table->boolean('is_active')->default(true);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};