<?php

require __DIR__ . '/../../vendor/autoload.php';
$app = require __DIR__ . '/../../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$locations = [
    'empresa1' => [
        'address' => 'Av. Hidalgo #305, Centro Histórico, Zacatecas, Zac., CP 98000',
        'neighborhood_zone' => 'Centro Histórico (Av. Hidalgo)',
        'city' => 'Zacatecas',
        'latitude' => 22.7748,
        'longitude' => -102.5732,
        'maps_url' => 'https://maps.google.com/?q=22.7748,-102.5732',
        'opening_hours' => 'Lunes a Sábado: 10:00 AM - 8:30 PM | Domingo: 11:00 AM - 6:00 PM',
        'location_reference' => 'Frente al Portal de Rosales, a 80 metros del Teatro Calderón',
        'whatsapp_number' => '+52 492 922 1450',
    ],
    'empresa2' => [
        'address' => 'Calle Tacuba #112, Col. Centro, Zacatecas, Zac., CP 98000',
        'neighborhood_zone' => 'Tacuba / Plazuela Goitia',
        'city' => 'Zacatecas',
        'latitude' => 22.7735,
        'longitude' => -102.5718,
        'maps_url' => 'https://maps.google.com/?q=22.7735,-102.5718',
        'opening_hours' => 'Lunes a Sábado: 9:30 AM - 8:00 PM',
        'location_reference' => 'A un costado de la Plazuela Goitia y Mercado González Ortega',
        'whatsapp_number' => '+52 492 924 8830',
    ],
    'Pepsi' => [
        'address' => 'Av. Juárez #215, Centro, Zacatecas, Zac., CP 98000',
        'neighborhood_zone' => 'Plaza de Armas / Catedral',
        'city' => 'Zacatecas',
        'latitude' => 22.7761,
        'longitude' => -102.5719,
        'maps_url' => 'https://maps.google.com/?q=22.7761,-102.5719',
        'opening_hours' => 'Lunes a Domingo: 8:00 AM - 9:00 PM',
        'location_reference' => 'A unos pasos del Palacio de Gobierno y Plaza de Armas',
        'whatsapp_number' => '+52 492 925 3310',
    ],
];

foreach ($locations as $tenantId => $loc) {
    // 1. Update central tenant
    \App\Models\Tenant::where('id', $tenantId)->update([
        'address' => $loc['address'],
        'neighborhood_zone' => $loc['neighborhood_zone'],
        'city' => $loc['city'],
        'latitude' => $loc['latitude'],
        'longitude' => $loc['longitude'],
        'maps_url' => $loc['maps_url'],
        'opening_hours' => $loc['opening_hours'],
        'location_reference' => $loc['location_reference'],
    ]);

    // 2. Update tenant store_settings
    $t = \App\Models\Tenant::find($tenantId);
    if ($t) {
        $t->run(function () use ($loc) {
            \App\Models\StoreSetting::updateOrCreate(
                ['id' => 1],
                $loc
            );
        });
    }
}

// Clear caches
\Illuminate\Support\Facades\Cache::forget('central_portal_businesses_list');
\Illuminate\Support\Facades\Cache::forget('platform_official_stores_list');

echo "Zacatecas Centro locations seeded successfully!" . PHP_EOL;
