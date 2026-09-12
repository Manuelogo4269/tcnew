<?php

namespace App\Filament\Tenant\Resources\StoreSettingResource\Pages;

use App\Filament\Tenant\Resources\StoreSettingResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditStoreSetting extends EditRecord
{
    protected static string $resource = StoreSettingResource::class;

    protected static ?string $title = 'Diseño, Colores y Personalización';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('visit_public_store')
                ->label('Ver Mi Tienda en Vivo')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('success')
                ->url(url('/'))
                ->openUrlInNewTab(),
        ];
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('¡Diseño actualizado!')
            ->body('Los cambios en colores, tipografía y estilo ya son visibles en tu tienda pública.');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->record]);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $rawLogoUrl = $this->record->getRawOriginal('logo_url');

        if ($rawLogoUrl && (str_starts_with($rawLogoUrl, 'http://') || str_starts_with($rawLogoUrl, 'https://'))) {
            // Clear for FileUpload so it does not fail checking external HTTP URLs on disk
            $data['logo_url'] = null;
        } else {
            // Supply raw disk path (e.g. 'logos/xyz.png') so FileUpload finds it on the public disk
            $data['logo_url'] = $rawLogoUrl;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Normalize array to string if Filament passed an array of paths
        if (is_array($data['logo_url'] ?? null)) {
            $data['logo_url'] = reset($data['logo_url']) ?: null;
        }

        $currentRaw = $this->record->getRawOriginal('logo_url');

        // If user didn't upload a new file, and record currently has an external URL, retain it
        if (empty($data['logo_url']) && !empty($currentRaw) && (str_starts_with($currentRaw, 'http://') || str_starts_with($currentRaw, 'https://'))) {
            $data['logo_url'] = $currentRaw;
        }

        return $data;
    }
}
