<?php

namespace App\Filament\Resources\TenantResource\Pages;

use App\Filament\Resources\TenantResource;
use App\Models\StoreSetting;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTenant extends EditRecord
{
    protected static string $resource = TenantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('visit_store')
                ->label('Ver Tienda Pública')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('gray')
                ->url(fn (): string => url('/tienda/' . strtolower($this->record->id)))
                ->openUrlInNewTab(),
            Actions\Action::make('visit_admin')
                ->label('Abrir Panel de la Tienda')
                ->icon('heroicon-o-cog-6-tooth')
                ->color('primary')
                ->url(fn (): string => url('/tienda/' . strtolower($this->record->id) . '/admin'))
                ->openUrlInNewTab(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $tenant = $this->record;

        $settings = $tenant->run(fn () => StoreSetting::first());

        if ($settings) {
            $data['store_name'] = $settings->store_name;
            $data['business_category'] = $settings->business_category ?? 'Comercio General';
            $data['tagline'] = $settings->tagline;
            $data['contact_email'] = $settings->contact_email;
            $data['primary_color'] = $settings->primary_color ?? '#d96b45';
            $data['secondary_color'] = $settings->secondary_color ?? '#f4efe7';
            $data['font_family'] = $settings->font_family ?? 'DM Sans';
            $rawLogo = $settings->getRawOriginal('logo_url');
            if ($rawLogo && (str_starts_with($rawLogo, 'http://') || str_starts_with($rawLogo, 'https://'))) {
                $data['logo_url'] = null;
            } else {
                $data['logo_url'] = $rawLogo;
            }
            $data['banner_url'] = $settings->banner_url;
            $data['hero_title'] = $settings->hero_title;
            $data['hero_subtitle'] = $settings->hero_subtitle;
            $data['hero_button_text'] = $settings->hero_button_text ?? 'Ver productos';
            $data['show_announcement'] = $settings->show_announcement ?? true;
            $data['announcement_text'] = $settings->announcement_text;
            $data['whatsapp_number'] = $settings->whatsapp_number;
            $data['instagram_url'] = $settings->instagram_url;
            $data['facebook_url'] = $settings->facebook_url;
            $data['official_website_url'] = $settings->official_website_url;
            $data['footer_text'] = $settings->footer_text;
        }

        return $data;
    }

    protected function afterSave(): void
    {
        $tenant = $this->record;
        $formData = $this->data;

        $tenant->run(function () use ($formData) {
            $rawLogo = $formData['logo_url'] ?? null;
            if (is_array($rawLogo)) {
                $rawLogo = reset($rawLogo) ?: null;
            }
            $existing = StoreSetting::first();
            $currentRaw = $existing?->getRawOriginal('logo_url');
            if (empty($rawLogo) && !empty($currentRaw) && (str_starts_with($currentRaw, 'http://') || str_starts_with($currentRaw, 'https://'))) {
                $rawLogo = $currentRaw;
            }

            StoreSetting::updateOrCreate(
                ['id' => 1],
                [
                    'store_name' => $formData['store_name'] ?? null,
                    'business_category' => $formData['business_category'] ?? 'Comercio General',
                    'tagline' => $formData['tagline'] ?? null,
                    'contact_email' => $formData['contact_email'] ?? null,
                    'primary_color' => $formData['primary_color'] ?? '#d96b45',
                    'secondary_color' => $formData['secondary_color'] ?? '#f4efe7',
                    'font_family' => $formData['font_family'] ?? 'DM Sans',
                    'logo_url' => $rawLogo,
                    'banner_url' => $formData['banner_url'] ?? null,
                    'hero_title' => $formData['hero_title'] ?? null,
                    'hero_subtitle' => $formData['hero_subtitle'] ?? null,
                    'hero_button_text' => $formData['hero_button_text'] ?? 'Ver productos',
                    'show_announcement' => (bool) ($formData['show_announcement'] ?? true),
                    'announcement_text' => $formData['announcement_text'] ?? null,
                    'whatsapp_number' => $formData['whatsapp_number'] ?? null,
                    'instagram_url' => $formData['instagram_url'] ?? null,
                    'facebook_url' => $formData['facebook_url'] ?? null,
                    'official_website_url' => $formData['official_website_url'] ?? null,
                    'footer_text' => $formData['footer_text'] ?? null,
                ]
            );

            // Update Admin User credentials if provided
            if (!empty($formData['admin_email'])) {
                $userUpdates = [
                    'name' => !empty($formData['admin_name']) ? trim($formData['admin_name']) : 'Admin',
                ];
                if (!empty($formData['admin_password'])) {
                    $userUpdates['password'] = \Illuminate\Support\Facades\Hash::make($formData['admin_password']);
                }
                \App\Models\TenantUser::updateOrCreate(
                    ['email' => trim($formData['admin_email'])],
                    $userUpdates
                );
            }
        });
    }
}
