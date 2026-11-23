<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Tenant;
use App\Models\StoreSetting;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $emojiPattern = '/[\x{1F300}-\x{1FAFF}\x{2600}-\x{26FF}\x{2700}-\x{27BF}]\x{FE0F}?/u';

        try {
            $tenants = Tenant::all();
            foreach ($tenants as $tenant) {
                // Clean tenant fields
                $tenantCleanTagline = trim(preg_replace('/\s+/', ' ', preg_replace($emojiPattern, '', $tenant->tagline ?? '')));
                $tenantCleanStoreName = trim(preg_replace('/\s+/', ' ', preg_replace($emojiPattern, '', $tenant->store_name ?? '')));
                $tenant->update([
                    'tagline' => $tenantCleanTagline,
                    'store_name' => $tenantCleanStoreName ?: $tenant->store_name,
                ]);

                // Run inside tenant database
                try {
                    $tenant->run(function () use ($emojiPattern) {
                        // 1. StoreSettings
                        $settings = StoreSetting::all();
                        foreach ($settings as $setting) {
                            $cleanTagline = trim(preg_replace('/\s+/', ' ', preg_replace($emojiPattern, '', $setting->tagline ?? '')));
                            $cleanAnn = trim(preg_replace('/\s+/', ' ', preg_replace($emojiPattern, '', $setting->announcement_text ?? '')));
                            $cleanStoreName = trim(preg_replace('/\s+/', ' ', preg_replace($emojiPattern, '', $setting->store_name ?? '')));
                            $cleanCat = trim(preg_replace('/\s+/', ' ', preg_replace($emojiPattern, '', $setting->business_category ?? '')));

                            $setting->update([
                                'tagline' => $cleanTagline,
                                'announcement_text' => $cleanAnn,
                                'store_name' => $cleanStoreName ?: $setting->store_name,
                                'business_category' => $cleanCat ?: $setting->business_category,
                            ]);
                        }

                        // 2. Categories
                        $categories = Category::all();
                        foreach ($categories as $cat) {
                            $cleanName = trim(preg_replace('/\s+/', ' ', preg_replace($emojiPattern, '', $cat->name ?? '')));
                            if ($cleanName !== $cat->name && !empty($cleanName)) {
                                $cat->update(['name' => $cleanName]);
                            }
                        }

                        // 3. Products
                        $products = Product::all();
                        foreach ($products as $prod) {
                            $cleanName = trim(preg_replace('/\s+/', ' ', preg_replace($emojiPattern, '', $prod->name ?? '')));
                            $cleanDesc = trim(preg_replace('/\s+/', ' ', preg_replace($emojiPattern, '', $prod->description ?? '')));
                            if ($cleanName !== $prod->name || $cleanDesc !== $prod->description) {
                                $prod->update([
                                    'name' => $cleanName ?: $prod->name,
                                    'description' => $cleanDesc ?: $prod->description,
                                ]);
                            }
                        }
                    });
                } catch (\Throwable $e) {
                    // Ignore tenant specific migration error and continue
                }
            }

            Cache::flush();
        } catch (\Throwable $e) {
            // General catch
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse needed
    }
};
