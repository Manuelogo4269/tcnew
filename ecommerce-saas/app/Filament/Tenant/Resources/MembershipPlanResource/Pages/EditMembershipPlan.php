<?php

namespace App\Filament\Tenant\Resources\MembershipPlanResource\Pages;

use App\Filament\Tenant\Resources\MembershipPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMembershipPlan extends EditRecord
{
    protected static string $resource = MembershipPlanResource::class;

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
