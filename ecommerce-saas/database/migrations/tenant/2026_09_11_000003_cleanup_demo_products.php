<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $demoSlugs = [
            'bolso-nomada-cuero',
            'zapatillas-lino-crudo',
            'jarron-ceramica-arena',
            'set-posavasos-marmol',
            'cargador-inalambrico-nogal',
        ];

        Product::whereIn('slug', $demoSlugs)->delete();

        $demoCatSlugs = [
            'ropa-accesorios',
            'hogar-decoracion',
            'tecnologia-accesorios',
        ];

        Category::whereIn('slug', $demoCatSlugs)->whereDoesntHave('products')->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
