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
}
