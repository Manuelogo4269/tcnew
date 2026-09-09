<?php

namespace App\Providers;

use App\Http\Middleware\InitializeTenancyForLivewire;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production') ||
            request()->isSecure() ||
            request()->header('X-Forwarded-Proto') === 'https' ||
            str_contains(request()->header('Host', ''), 'onrender.com')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        Livewire::setUpdateRoute(function ($handle) {
            return Route::post('/livewire/update', $handle)
                ->middleware([
                    'web',
                    InitializeTenancyForLivewire::class,
                ])
                ->name('livewire.update');
        });
    }
}
