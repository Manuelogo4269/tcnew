<?php

namespace App\Filament\Resources\TenantResource\Pages;

use App\Filament\Resources\TenantResource;
use App\Models\StoreSetting;
use Database\Seeders\TenantSeeder;
use Filament\Resources\Pages\CreateRecord;

class CreateTenant extends CreateRecord
{
    protected static string $resource = TenantResource::class;

    protected function afterCreate(): void
    {
        $tenant = $this->record;
        $subdomain = strtolower($tenant->id);

        $tenant->createDomain($subdomain);
        $tenant->createDomain($subdomain . '.localhost');

        $formData = $this->data;

        $tenant->run(function () use ($formData, $tenant) {
            // Populate basic default catalog
            (new TenantSeeder())->run();

            // Apply custom store settings entered in the form
            if (! empty($formData['store_name']) || ! empty($formData['primary_color'])) {
                StoreSetting::updateOrCreate(
                    ['id' => 1],
                    [
                        'store_name' => $formData['store_name'] ?? str($tenant->id)->title()->toString(),
                        'tagline' => $formData['tagline'] ?? null,
                        'contact_email' => $formData['contact_email'] ?? null,
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
                    ]
                );
            }
        });
    }
}
