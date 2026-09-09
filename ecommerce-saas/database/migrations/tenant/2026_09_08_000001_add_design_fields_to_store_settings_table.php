<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('store_settings', function (Blueprint $table) {
            $table->string('secondary_color')->nullable()->default('#f4efe7');
            $table->string('font_family')->nullable()->default('DM Sans');
            $table->string('tagline')->nullable();
            $table->boolean('show_announcement')->default(true);
            $table->string('announcement_text')->nullable();
            $table->string('hero_title')->nullable();
            $table->text('hero_subtitle')->nullable();
            $table->string('hero_button_text')->nullable()->default('Ver productos');
            $table->string('whatsapp_number')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('footer_text')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('store_settings', function (Blueprint $table) {
            $table->dropColumn([
                'secondary_color',
                'font_family',
                'tagline',
                'show_announcement',
                'announcement_text',
                'hero_title',
                'hero_subtitle',
                'hero_button_text',
                'whatsapp_number',
                'instagram_url',
                'facebook_url',
                'footer_text',
            ]);
        });
    }
};
