<?php

namespace App\Filament\Tenant\Resources\CustomerResource\Pages;

use App\Filament\Tenant\Resources\CustomerResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['password'] = Hash::make(Str::random(16));
        return $data;
    }
}
