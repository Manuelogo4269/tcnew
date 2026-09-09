<?php

namespace App\Filament\Tenant\Resources\StoreSettingResource\Pages;

use App\Filament\Tenant\Resources\StoreSettingResource;
use App\Models\StoreSetting;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStoreSettings extends ListRecords
{
    protected static string $resource = StoreSettingResource::class;

    public function mount(): void
    {
        $tenantId = (string) tenant('id');
        $setting = StoreSetting::firstOrCreate(
            ['id' => 1],
            [
                'store_name' => str($tenantId)->replace(['-', '_'], ' ')->title()->toString(),
                'primary_color' => '#d96b45',
                'secondary_color' => '#f4efe7',
                'font_family' => 'DM Sans',
                'show_announcement' => true,
                'hero_title' => 'Calidad y diseño. Hecho para ti.',
                'hero_subtitle' => 'Explora nuestra colección seleccionada con total privacidad y control de inventario.',
                'hero_button_text' => 'Ver productos',
            ]
        );

        $this->redirect(StoreSettingResource::getUrl('edit', ['record' => $setting]));
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
