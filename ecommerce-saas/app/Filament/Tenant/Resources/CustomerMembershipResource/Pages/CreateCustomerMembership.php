<?php

namespace App\Filament\Tenant\Resources\CustomerMembershipResource\Pages;

use App\Filament\Tenant\Resources\CustomerMembershipResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerMembership extends CreateRecord
{
    protected static string $resource = CustomerMembershipResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
