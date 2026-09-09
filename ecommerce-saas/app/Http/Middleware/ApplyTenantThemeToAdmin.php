<?php

namespace App\Http\Middleware;

use App\Models\StoreSetting;
use Closure;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Filament\View\PanelsRenderHook;
use Filament\Support\Facades\FilamentView;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;
use Symfony\Component\HttpFoundation\Response;

class ApplyTenantThemeToAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (function_exists('tenancy') && tenancy()->initialized) {
            $settings = StoreSetting::first();
            $primaryColor = $settings?->primary_color ?? '#d96b45';

            try {
                FilamentColor::register([
                    'primary' => Color::hex($primaryColor),
                ]);
            } catch (\Throwable $e) {
                // Fallback gracefully if color is custom or invalid
            }

            FilamentView::registerRenderHook(
                PanelsRenderHook::HEAD_END,
                function () use ($primaryColor) {
                    return new HtmlString("
                        <style>
                            :root {
                                --tenant-brand-primary: {$primaryColor};
                            }
                            .fi-topbar {
                                border-bottom: 2px solid {$primaryColor}30 !important;
                            }
                            .fi-btn-primary {
                                background-color: {$primaryColor} !important;
                                border-color: {$primaryColor} !important;
                            }
                            .fi-sidebar-item-active .fi-sidebar-item-button {
                                background-color: {$primaryColor}18 !important;
                                color: {$primaryColor} !important;
                                font-weight: 600;
                            }
                            .fi-sidebar-item-active .fi-sidebar-item-icon {
                                color: {$primaryColor} !important;
                            }
                            .atelier-dashboard__orb {
                                background: linear-gradient(135deg, {$primaryColor}, {$primaryColor}dd) !important;
                            }
                            .atelier-dashboard__stat:hover {
                                border-color: {$primaryColor} !important;
                                box-shadow: 0 10px 25px {$primaryColor}25 !important;
                            }
                            .atelier-dashboard__quick:hover {
                                border-color: {$primaryColor} !important;
                                box-shadow: 0 10px 25px {$primaryColor}20 !important;
                            }
                        </style>
                    ");
                }
            );
        }

        return $next($request);
    }
}
