<?php

namespace App\Filament\Tenant\Resources\CustomerMembershipResource\Pages;

use App\Filament\Tenant\Resources\CustomerMembershipResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerMemberships extends ListRecords
{
    protected static string $resource = CustomerMembershipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Registrar Socio'),
        ];
    }
}
