<?php

namespace App\Filament\Tenant\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string $view = 'filament.tenant.pages.dashboard';

    protected static ?string $title = 'Resumen de tu tienda';

    protected static ?string $navigationLabel = 'Resumen';

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
}
