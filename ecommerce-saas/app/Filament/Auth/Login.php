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

    public function mount(): void
    {
        parent::mount();

        if (Filament::getCurrentPanel()?->getId() === 'tenant') {
            $tenantId = session('tenant_admin_tenant_id') 
                ?: request()->query('tenant') 
                ?: request()->cookie('tenant_admin_tenant_id');

            $tenant = null;
            if ($tenantId) {
                $tenant = Tenant::find($tenantId) ?? Tenant::whereRaw('LOWER(id) = ?', [strtolower($tenantId)])->first();
            }
            if (!$tenant) {
                $tenant = Tenant::where('id', 'not like', 'test%')->first();
            }

            if ($tenant) {
                $adminEmail = $tenant->run(fn () => \App\Models\TenantUser::value('email')) ?? "admin@{$tenant->id}.com";
                $this->form->fill([
                    'email' => $adminEmail,
                    'remember' => true,
                ]);
            }
        }
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        // Ensure tenancy is ended if in central admin panel
        if (Filament::getCurrentPanel()?->getId() === 'admin' && function_exists('tenancy') && tenancy()->initialized) {
            tenancy()->end();
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

        // 3. Multi-Tenant Auto-Discovery: If not authenticated in current tenant DB, discover correct tenant
        if (! $authenticated && Filament::getCurrentPanel()?->getId() === 'tenant' && !empty($credentials['email'])) {
            $inputEmail = strtolower(trim($credentials['email']));
            
            // A. Check by email domain (e.g. admin@donajulia.com -> donajulia)
            $candidateTenantId = null;
            if (str_contains($inputEmail, '@')) {
                $domainPart = explode('@', $inputEmail)[1];
                $candidateTenantId = explode('.', $domainPart)[0];
            }
            
            $candidateTenant = null;
            if ($candidateTenantId) {
                $candidateTenant = Tenant::where('id', $candidateTenantId)
                    ->orWhereRaw('LOWER(id) = ?', [strtolower($candidateTenantId)])
                    ->first();
            }

            // If candidate tenant found, switch tenancy and attempt authentication
            if ($candidateTenant) {
                if (function_exists('tenancy') && tenancy()->initialized) {
                    tenancy()->end();
                }
                tenancy()->initialize($candidateTenant);
                session(['tenant_admin_tenant_id' => $candidateTenant->id]);
                cookie()->queue(cookie('tenant_admin_tenant_id', $candidateTenant->id, 60 * 24 * 30));

                $authenticated = Filament::auth()->attempt($credentials, $remember);
                if (! $authenticated && isset($credentials['password']) && in_array($credentials['password'], ['password', 'password123'])) {
                    $altPassword = $credentials['password'] === 'password' ? 'password123' : 'password';
                    $altCredentials = array_merge($credentials, ['password' => $altPassword]);
                    $authenticated = Filament::auth()->attempt($altCredentials, $remember);
                }
            }

            // B. If still not authenticated, search across all real tenants
            if (! $authenticated) {
                $allTenants = Tenant::where('id', 'not like', 'test%')->get();
                foreach ($allTenants as $t) {
                    if ($candidateTenant && $t->id === $candidateTenant->id) {
                        continue;
                    }
                    $userExists = $t->run(function () use ($inputEmail) {
                        return \App\Models\TenantUser::whereRaw('LOWER(email) = ?', [$inputEmail])->exists();
                    });

                    if ($userExists) {
                        if (function_exists('tenancy') && tenancy()->initialized) {
                            tenancy()->end();
                        }
                        tenancy()->initialize($t);
                        session(['tenant_admin_tenant_id' => $t->id]);
                        cookie()->queue(cookie('tenant_admin_tenant_id', $t->id, 60 * 24 * 30));

                        $authenticated = Filament::auth()->attempt($credentials, $remember);
                        if (! $authenticated && isset($credentials['password']) && in_array($credentials['password'], ['password', 'password123'])) {
                            $altPassword = $credentials['password'] === 'password' ? 'password123' : 'password';
                            $altCredentials = array_merge($credentials, ['password' => $altPassword]);
                            $authenticated = Filament::auth()->attempt($altCredentials, $remember);
                        }

                        if ($authenticated) {
                            break;
                        }
                    }
                }
            }
        }

        if ($authenticated && Filament::getCurrentPanel()?->getId() === 'tenant' && function_exists('tenancy') && tenancy()->initialized) {
            session(['tenant_admin_tenant_id' => tenant('id')]);
            cookie()->queue(cookie('tenant_admin_tenant_id', tenant('id'), 60 * 24 * 30));
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
