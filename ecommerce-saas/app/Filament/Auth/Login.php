<?php

namespace App\Filament\Auth;

use App\Models\Tenant;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Models\Contracts\FilamentUser;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    protected static string $view = 'filament.auth.login';

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        // Ensure tenancy is initialized if in tenant panel
        if (Filament::getCurrentPanel()?->getId() === 'tenant' && (!function_exists('tenancy') || !tenancy()->initialized)) {
            $tenantId = session('tenant_admin_tenant_id') ?: request()->query('tenant');
            if ($tenantId) {
                $tenant = Tenant::find($tenantId) ?? Tenant::whereRaw('LOWER(id) = ?', [strtolower($tenantId)])->first();
                if ($tenant) {
                    tenancy()->initialize($tenant);
                }
            }
        }

        $data = $this->form->getState();
        $credentials = $this->getCredentialsFromFormData($data);
        $remember = (bool) ($data['remember'] ?? false);

        // 1. Standard authentication attempt
        $authenticated = Filament::auth()->attempt($credentials, $remember);

        // 2. Demo accounts convenience: accept either 'password' or 'password123'
        if (!$authenticated && isset($credentials['password']) && in_array($credentials['password'], ['password', 'password123'])) {
            $altPassword = $credentials['password'] === 'password' ? 'password123' : 'password';
            $altCredentials = array_merge($credentials, ['password' => $altPassword]);
            $authenticated = Filament::auth()->attempt($altCredentials, $remember);
        }

        if (!$authenticated) {
            $this->throwFailureValidationException();
        }

        $user = Filament::auth()->user();

        if (
            ($user instanceof FilamentUser) &&
            (! $user->canAccessPanel(Filament::getCurrentPanel()))
        ) {
            Filament::auth()->logout();

            $this->throwFailureValidationException();
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }
}
