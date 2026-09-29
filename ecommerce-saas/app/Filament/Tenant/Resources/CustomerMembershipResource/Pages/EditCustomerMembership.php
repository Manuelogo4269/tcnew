<?php

namespace App\Filament\Tenant\Resources\CustomerMembershipResource\Pages;

use App\Filament\Tenant\Resources\CustomerMembershipResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerMembership extends EditRecord
{
    protected static string $resource = CustomerMembershipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
