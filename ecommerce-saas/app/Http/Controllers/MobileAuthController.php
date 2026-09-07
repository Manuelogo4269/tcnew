<?php

namespace App\Http\Controllers;

use App\Models\CustomerAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class MobileAuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', 'unique:central.customer_accounts,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $account = CustomerAccount::create($data);

        return response()->json($this->tokenResponse($account), 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $account = CustomerAccount::where('email', $data['email'])->first();

        if (! $account || ! Hash::check($data['password'], $account->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales no son válidas.'],
            ]);
        }

        return response()->json($this->tokenResponse($account));
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json(['message' => 'Sesión cerrada.']);
    }

    private function tokenResponse(CustomerAccount $account): array
    {
        return [
            'user' => $account,
            'token' => $account->createToken('mobile')->plainTextToken,
        ];
    }
}
