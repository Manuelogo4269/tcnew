<?php

namespace App\Http\Controllers;

use App\Models\CustomerAccount;
use App\Models\Product;
use App\Models\Tenant;
use App\Models\TenantUser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MobileStoreController extends Controller
{
    public function index()
    {
        return Tenant::with('domains')->get()->map(fn (Tenant $tenant) => [
            'id' => $tenant->id,
            'name' => str($tenant->id)->replace(['-', '_'], ' ')->title()->toString(),
            'domains' => $tenant->domains->pluck('domain')->values(),
        ]);
    }

    public function products(string $tenant)
    {
        $tenantModel = Tenant::findOrFail($tenant);

        return $tenantModel->run(fn () => Product::query()
            ->where('is_active', true)
            ->with('category:id,name,slug')
            ->latest()
            ->paginate(20));
    }

    public function join(Request $request, string $tenant)
    {
        /** @var CustomerAccount $account */
        $account = $request->user();
        $tenantModel = Tenant::findOrFail($tenant);

        return $tenantModel->run(function () use ($account) {
            $user = TenantUser::firstOrCreate(
                ['customer_account_id' => (string) $account->id],
                [
                    'name' => $account->name,
                    'email' => $account->email,
                    'password' => Str::random(64),
                ],
            );

            return response()->json([
                'message' => 'Cuenta vinculada a la tienda.',
                'store' => tenant('id'),
                'user' => $user,
            ]);
        });
    }
}
