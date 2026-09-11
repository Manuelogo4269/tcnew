<?php

namespace App\Filament\Tenant\Resources\ProductResource\Pages;

use App\Filament\Tenant\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $rawImageUrl = $this->record->getRawOriginal('image_url');

        if ($rawImageUrl && (str_starts_with($rawImageUrl, 'http://') || str_starts_with($rawImageUrl, 'https://'))) {
            // Clear for FileUpload so it does not fail checking external HTTP URLs on disk
            $data['image_url'] = null;
        } else {
            // Supply raw disk path (e.g. 'products/xyz.jpg') so FileUpload finds it on the public disk
            $data['image_url'] = $rawImageUrl;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Normalize array to string if Filament passed an array of paths
        if (is_array($data['image_url'] ?? null)) {
            $data['image_url'] = reset($data['image_url']) ?: null;
        }

        $currentRaw = $this->record->getRawOriginal('image_url');

        // If user didn't upload a new file, and record currently has an external URL, retain it
        if (empty($data['image_url']) && !empty($currentRaw) && (str_starts_with($currentRaw, 'http://') || str_starts_with($currentRaw, 'https://'))) {
            $data['image_url'] = $currentRaw;
        }

        return $data;
    }
}
