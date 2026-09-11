<?php

namespace App\Filament\Tenant\Resources\OrderResource\Pages;

use App\Filament\Tenant\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (empty($data['folio']) && $this->record) {
            $prefix = strtoupper(substr(tenant('id') ?? 'CONC', 0, 4));
            $data['folio'] = $this->record->folio ?: \App\Models\Order::generateFolio($prefix);
        }

        return $data;
    }
}
