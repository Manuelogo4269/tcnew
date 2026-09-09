<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;

class InitializeTenancyForTenantAdmin
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (function_exists('tenancy') && tenancy()->initialized) {
            return $next($request);
        }

        $host = $request->getHost();
        $centralDomains = (array) config('tenancy.central_domains', [
            'localhost',
            '127.0.0.1',
            '192.168.0.128',
            '192.168.0.128.nip.io',
            '127.0.0.1.nip.io',
            'atelier-zacatecas.onrender.com',
        ]);

        // 1. Identify by Subdomain (e.g. acropolis.localhost, acropolis.127.0.0.1.nip.io)
        $subdomain = null;
        foreach ($centralDomains as $centralDomain) {
            if ($centralDomain && str_ends_with($host, '.' . $centralDomain)) {
                $prefix = substr($host, 0, -strlen('.' . $centralDomain));
                $parts = explode('.', $prefix);
                $subdomain = end($parts) ?: $prefix;
                break;
            }
        }

        if ($subdomain) {
            $tenant = Tenant::where('id', $subdomain)
                ->orWhereRaw('LOWER(id) = ?', [strtolower($subdomain)])
                ->orWhereHas('domains', function ($q) use ($subdomain) {
                    $q->where('domain', $subdomain);
                })
                ->first();

            if ($tenant) {
                tenancy()->initialize($tenant);
                session(['tenant_admin_tenant_id' => $tenant->id]);
                return $next($request);
            }
        }

        // 2. Identify by Query Parameter (?tenant=acropolis) or Session on Central Domain
        $tenantParam = $request->query('tenant') ?: session('tenant_admin_tenant_id');
        if ($tenantParam) {
            $tenant = Tenant::where('id', $tenantParam)
                ->orWhereRaw('LOWER(id) = ?', [strtolower($tenantParam)])
                ->first();

            if ($tenant) {
                tenancy()->initialize($tenant);
                session(['tenant_admin_tenant_id' => $tenant->id]);
                return $next($request);
            }
        }

        // 3. Fallback: If logged into Central Super Admin, redirect to Tenants list
        if (auth()->guard('web')->check()) {
            return redirect('/admin/tenants');
        }

        // Otherwise redirect to main platform home
        return redirect('/');
    }
}
