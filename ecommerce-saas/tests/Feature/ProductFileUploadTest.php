<?php

namespace Tests\Feature;

use App\Filament\Tenant\Resources\ProductResource\Pages\CreateProduct;
use App\Filament\Tenant\Resources\ProductResource\Pages\EditProduct;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tenant;
use Filament\Facades\Filament;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class ProductFileUploadTest extends TestCase
{
    public function test_product_image_url_accessor_handles_both_local_paths_and_external_urls(): void
    {
        $localProduct = new Product();
        $localProduct->setRawAttributes(['image_url' => 'products/joya1.jpg'], true);
        $this->assertStringContainsString('/storage/products/joya1.jpg', $localProduct->image_url);

        $externalProduct = new Product();
        $externalProduct->setRawAttributes(['image_url' => 'https://images.unsplash.com/photo-example'], true);
        $this->assertEquals('https://images.unsplash.com/photo-example', $externalProduct->image_url);

        $emptyProduct = new Product();
        $emptyProduct->setRawAttributes(['image_url' => null], true);
        $this->assertNull($emptyProduct->image_url);
    }

    public function test_can_create_product_with_uploaded_file_and_edit_without_losing_it(): void
    {
        Storage::fake('public');

        $tenant = Tenant::findOrFail('conceptos7');
        tenancy()->initialize($tenant);
        Filament::setCurrentPanel(Filament::getPanel('tenant'));

        $category = Category::firstOrCreate(['name' => 'Accesorios'], ['slug' => 'accesorios']);

        $fakeFile = UploadedFile::fake()->create('producto_nuevo.jpg', 100, 'image/jpeg');

        Livewire::test(CreateProduct::class)
            ->fillForm([
                'category_id' => $category->id,
                'name' => 'Pulsera de Circonias Plata',
                'slug' => 'pulsera-de-circonias-plata',
                'price' => 299.00,
                'stock' => 8,
                'image_url' => $fakeFile,
                'is_active' => true,
                'description' => 'Pulsera elaborada a mano con circonias brillantes.',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $product = Product::where('slug', 'pulsera-de-circonias-plata')->first();
        $this->assertNotNull($product);

        $rawPath = $product->getRawOriginal('image_url');
        $this->assertNotNull($rawPath);
        $this->assertStringStartsWith('products/', $rawPath);
        Storage::disk('public')->assertExists($rawPath);
        $this->assertStringContainsString('/storage/products/', $product->image_url);

        // Edit product without changing the image
        Livewire::test(EditProduct::class, ['record' => $product->getKey()])
            ->fillForm([
                'price' => 279.00,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $product->refresh();
        $this->assertEquals(279.00, (float) $product->price);
        $this->assertEquals($rawPath, $product->getRawOriginal('image_url'));
        Storage::disk('public')->assertExists($rawPath);

        // Clean up
        $product->delete();
    }

    public function test_editing_product_with_external_url_preserves_url_when_no_new_file_uploaded(): void
    {
        $tenant = Tenant::findOrFail('conceptos7');
        tenancy()->initialize($tenant);
        Filament::setCurrentPanel(Filament::getPanel('tenant'));

        Product::where('slug', 'like', 'anillo-test-externo%')->delete();

        $category = Category::first();
        $externalUrl = 'https://images.unsplash.com/photo-test-jewel?auto=format';
        $slug = 'anillo-test-externo-' . uniqid();

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Anillo Test Externo',
            'slug' => $slug,
            'price' => 150.00,
            'stock' => 5,
            'image_url' => $externalUrl,
            'is_active' => true,
            'description' => 'Test external jewel',
        ]);

        Livewire::test(EditProduct::class, ['record' => $product->getKey()])
            ->fillForm([
                'stock' => 12,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $product->refresh();
        $this->assertEquals(12, $product->stock);
        $this->assertEquals($externalUrl, $product->getRawOriginal('image_url'));

        $product->delete();
    }
}
