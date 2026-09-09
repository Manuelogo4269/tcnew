<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('reviewable_type')->index(); // 'company' or 'product'
            $table->string('reviewable_id')->index();   // tenant id or product id/slug
            $table->string('author_name');
            $table->unsignedTinyInteger('rating')->default(5); // 1 to 5
            $table->text('comment');
            $table->boolean('verified_purchase')->default(true);
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};