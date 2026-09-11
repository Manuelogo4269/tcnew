<?php

namespace App\Filament\Tenant\Resources\OrderResource\Pages;

use App\Filament\Tenant\Resources\OrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['folio'])) {
            $prefix = strtoupper(substr(tenant('id') ?? 'CONC', 0, 4));
            $data['folio'] = \App\Models\Order::generateFolio($prefix);
        }

        if (empty($data['total_amount']) && !empty($data['items']) && is_array($data['items'])) {
            $total = 0;
            foreach ($data['items'] as $item) {
                $total += ((int)($item['quantity'] ?? 1)) * ((float)($item['price'] ?? 0));
            }
            $data['total_amount'] = $total;
        }

        return $data;
    }
}
