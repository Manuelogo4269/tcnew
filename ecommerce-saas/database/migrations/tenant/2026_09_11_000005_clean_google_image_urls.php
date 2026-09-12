<?php

use App\Models\StoreSetting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $setting = StoreSetting::first();
        if ($setting && !empty($setting->logo_url)) {
            if (str_contains($setting->logo_url, 'google.') && str_contains($setting->logo_url, 'imgurl=')) {
                parse_str(parse_url($setting->logo_url, PHP_URL_QUERY) ?? '', $query);
                if (!empty($query['imgurl'])) {
                    $setting->logo_url = $query['imgurl'];
                    $setting->save();
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
