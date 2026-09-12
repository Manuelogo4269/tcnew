<?php

namespace Tests\Feature;

use App\Filament\Tenant\Resources\StoreSettingResource\Pages\EditStoreSetting;
use App\Models\StoreSetting;
use App\Models\Tenant;
use Filament\Facades\Filament;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class StoreLogoUploadTest extends TestCase
{
    public function test_store_setting_logo_url_accessor_handles_local_paths_and_external_urls(): void
    {
        $localSetting = new StoreSetting();
        $localSetting->setRawAttributes(['logo_url' => 'logos/brand_logo.png'], true);
        $this->assertStringContainsString('/storage/logos/brand_logo.png', $localSetting->logo_url);

        $externalSetting = new StoreSetting();
        $externalSetting->setRawAttributes(['logo_url' => 'https://example.com/logo.svg'], true);
        $this->assertEquals('https://example.com/logo.svg', $externalSetting->logo_url);

        $emptySetting = new StoreSetting();
        $emptySetting->setRawAttributes(['logo_url' => null], true);
        $this->assertNull($emptySetting->logo_url);
    }

    public function test_store_setting_falls_back_to_logo_data_when_file_missing(): void
    {
        $base64Sample = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';
        
        $setting = new StoreSetting();
        $setting->setRawAttributes([
            'logo_url' => 'logos/missing_file.png',
            'logo_data' => $base64Sample,
        ], true);

        // When physical file does not exist on disk, it should return the persisted base64 logo_data
        $this->assertEquals($base64Sample, $setting->logo_url);
    }

    public function test_can_upload_store_logo_via_tenant_settings(): void
    {
        Storage::fake('public');

        $tenant = Tenant::findOrFail('conceptos7');
        tenancy()->initialize($tenant);
        Filament::setCurrentPanel(Filament::getPanel('tenant'));

        $setting = StoreSetting::firstOrCreate(['id' => 1]);
        $originalRawLogo = $setting->getRawOriginal('logo_url');

        $fakeLogo = UploadedFile::fake()->create('mi_logotipo.png', 100, 'image/png');

        Livewire::test(EditStoreSetting::class, ['record' => $setting->getKey()])
            ->fillForm([
                'logo_url' => $fakeLogo,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $setting->refresh();
        $rawPath = $setting->getRawOriginal('logo_url');
        $this->assertNotNull($rawPath);
        $this->assertStringStartsWith('logos/', $rawPath);
        Storage::disk('public')->assertExists($rawPath);

        // Accessor should provide asset URL or valid image link
        $this->assertStringContainsString('/storage/logos/', $setting->logo_url);

        // Clean up
        $setting->update(['logo_url' => $originalRawLogo, 'logo_data' => null]);
    }

    public function test_editing_store_settings_preserves_external_logo_url_when_no_new_file_uploaded(): void
    {
        $tenant = Tenant::findOrFail('conceptos7');
        tenancy()->initialize($tenant);
        Filament::setCurrentPanel(Filament::getPanel('tenant'));

        $setting = StoreSetting::firstOrCreate(['id' => 1]);
        $originalRawLogo = $setting->getRawOriginal('logo_url');

        $externalUrl = 'https://images.unsplash.com/photo-brand-logo-custom';
        $setting->update(['logo_url' => $externalUrl]);

        Livewire::test(EditStoreSetting::class, ['record' => $setting->getKey()])
            ->fillForm([
                'tagline' => 'Nueva frase de prueba',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $setting->refresh();
        $this->assertEquals($externalUrl, $setting->getRawOriginal('logo_url'));
        $this->assertEquals('Nueva frase de prueba', $setting->tagline);

        // Clean up
        $setting->update(['logo_url' => $originalRawLogo]);
    }
}
