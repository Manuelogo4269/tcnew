<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;

class InitializeTenancyForLivewire
{
    public function handle(Request $request, Closure $next): mixed
    {
        $host = $request->getHost();

        if (in_array($host, config('tenancy.central_domains', []), true)) {
            return $next($request);
        }

        return app(InitializeTenancyBySubdomain::class)->handle($request, $next);
    }
}
