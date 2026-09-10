<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;

class InitializeTenancyForLivewire
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (function_exists('tenancy') && tenancy()->initialized) {
            return $next($request);
        }

        $host = $request->getHost();
        $centralDomains = (array) config('tenancy.central_domains', []);

        // 1. If not a central domain, attempt subdomain identification
        if (!in_array($host, $centralDomains, true)) {
            return app(InitializeTenancyBySubdomain::class)->handle($request, $next);
        }

        // Never initialize tenancy for central admin panel (/admin)
        $referer = (string) $request->headers->get('referer', '');
        if (str_contains($referer, '/admin') && !str_contains($referer, '/tenant-admin')) {
            return $next($request);
        }

        // 2. If on a central domain, identify tenant from query, referer, or session
        $tenantId = $request->query('tenant');

        if (!$tenantId && preg_match('#/tienda/([^/?]+)#', $referer, $matches)) {
            $tenantId = $matches[1];
        }

        if (!$tenantId && str_contains($referer, '/tenant-admin') && $request->hasSession()) {
            $tenantId = $request->session()->get('tenant_admin_tenant_id');
        }

        if ($tenantId) {
            $tenant = Tenant::where('id', $tenantId)
                ->orWhereRaw('LOWER(id) = ?', [strtolower($tenantId)])
                ->orWhereHas('domains', function ($q) use ($tenantId) {
                    $q->where('domain', $tenantId);
                })
                ->first();

            if ($tenant) {
                tenancy()->initialize($tenant);
                if ($request->hasSession()) {
                    $request->session()->put('tenant_admin_tenant_id', $tenant->id);
                }
            }
        }

        return $next($request);
    }
}
