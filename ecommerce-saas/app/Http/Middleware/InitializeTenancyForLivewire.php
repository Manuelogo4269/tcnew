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

        // 2. If on a central domain, identify tenant from session, query, or referer
        $tenantId = null;
        if ($request->hasSession()) {
            $tenantId = $request->session()->get('tenant_admin_tenant_id');
        }
        if (!$tenantId) {
            $tenantId = $request->query('tenant');
        }
        if (!$tenantId && $request->headers->has('referer')) {
            $referer = (string) $request->headers->get('referer');
            if (preg_match('#/tienda/([^/?]+)#', $referer, $matches)) {
                $tenantId = $matches[1];
            }
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
