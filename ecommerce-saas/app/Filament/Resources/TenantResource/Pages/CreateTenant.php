<?php

namespace App\Filament\Resources\TenantResource\Pages;

use App\Filament\Resources\TenantResource;
use App\Models\StoreSetting;
use App\Models\TenantUser;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateTenant extends CreateRecord
{
    protected static string $resource = TenantResource::class;

    protected function afterCreate(): void
    {
        $tenant = $this->record;
        $subdomain = strtolower($tenant->id);

        $tenant->createDomain($subdomain);
        $tenant->createDomain($subdomain . '.atelier-zacatecas.onrender.com');
        $tenant->createDomain($subdomain . '.localhost');

        $formData = $this->data;

        $tenant->run(function () use ($formData, $tenant) {
            // 1. Create Tenant Admin User
            $cleanId = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $tenant->id));
            $adminEmail = !empty($formData['contact_email']) ? $formData['contact_email'] : "admin@{$cleanId}.com";
            $storeTitle = $formData['store_name'] ?? str($tenant->id)->replace(['-', '_'], ' ')->title()->toString();

            TenantUser::firstOrCreate(
                ['email' => $adminEmail],
                [
                    'name' => "Admin {$storeTitle}",
                    'password' => Hash::make('password'),
                ]
            );

            // 2. Initialize Store Settings (Clean catalog, no demo products)
            StoreSetting::updateOrCreate(
                ['id' => 1],
                [
                    'store_name' => $formData['store_name'] ?? $storeTitle,
                    'tagline' => $formData['tagline'] ?? null,
                    'contact_email' => $formData['contact_email'] ?? $adminEmail,
                    'primary_color' => $formData['primary_color'] ?? '#d96b45',
                    'secondary_color' => $formData['secondary_color'] ?? '#f4efe7',
                    'font_family' => $formData['font_family'] ?? 'DM Sans',
                    'logo_url' => $formData['logo_url'] ?? null,
                    'banner_url' => $formData['banner_url'] ?? null,
                    'hero_title' => $formData['hero_title'] ?? null,
                    'hero_subtitle' => $formData['hero_subtitle'] ?? null,
                    'hero_button_text' => $formData['hero_button_text'] ?? 'Ver productos',
                    'show_announcement' => (bool) ($formData['show_announcement'] ?? true),
                    'announcement_text' => $formData['announcement_text'] ?? null,
                    'whatsapp_number' => $formData['whatsapp_number'] ?? null,
                    'instagram_url' => $formData['instagram_url'] ?? null,
                    'facebook_url' => $formData['facebook_url'] ?? null,
                    'footer_text' => $formData['footer_text'] ?? null,
                    'layout_blocks' => StoreSetting::defaultLayoutBlocks(),
                ]
            );
        });
    }
}
