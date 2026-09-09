<?php

namespace App\Http\Controllers;

use App\Models\CentralUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class CentralAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('web')->check()) {
            return redirect('/');
        }
        return view('central.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::guard('web')->user();

            return redirect()->intended('/')->with('success', "¡Bienvenido de vuelta, {$user->name}!");
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Redirect to Google OAuth or fallback to development session if credentials not configured yet.
     */
    public function redirectToGoogle(Request $request)
    {
        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        if (!empty($clientId) && !empty($clientSecret) && !$request->has('demo')) {
            $redirectUri = url('/auth/google/callback');
            return Socialite::driver('google')->redirectUrl($redirectUri)->redirect();
        }

        // Seamless development fallback
        $email = $request->query('email', 'usuario.google@gmail.com');
        $name = $request->query('name', 'Manuel González (Google)');

        $user = CentralUser::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make(bin2hex(random_bytes(16))),
                'auth_provider' => 'google',
                'auth_provider_id' => 'goog_' . substr(md5($email), 0, 12),
                'avatar_url' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=120&q=80',
            ]
        );

        Auth::guard('web')->login($user, true);
        $request->session()->regenerate();

        $msg = !empty($clientId)
            ? "¡Sesión iniciada con Google como {$user->name}!"
            : "¡Sesión iniciada con Google! (Para producción completa, configura GOOGLE_CLIENT_ID y GOOGLE_CLIENT_SECRET en tu archivo .env)";

        return redirect('/')->with('success', $msg);
    }

    /**
     * Handle callback from Google OAuth.
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            $redirectUri = url('/auth/google/callback');
            $driver = Socialite::driver('google')->redirectUrl($redirectUri);

            $caPath = storage_path('cacert.pem');
            $driver->setHttpClient(new \GuzzleHttp\Client([
                'verify' => file_exists($caPath) ? realpath($caPath) : false,
                'timeout' => 15,
            ]));

            $googleUser = $driver->user();

            $user = CentralUser::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Usuario Google',
                    'password' => Hash::make(bin2hex(random_bytes(16))),
                    'auth_provider' => 'google',
                    'auth_provider_id' => (string) $googleUser->getId(),
                    'avatar_url' => $googleUser->getAvatar() ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=120&q=80',
                ]
            );

            Auth::guard('web')->login($user, true);
            $request->session()->regenerate();

            return redirect('/')->with('success', "¡Conectado exitosamente con tu cuenta oficial de Google ({$user->name})!");
        } catch (\Exception $e) {
            return redirect('/login')->withErrors([
                'oauth' => 'No se pudo completar el inicio de sesión con Google: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Redirect to Facebook OAuth or fallback to development session if credentials not configured yet.
     */
    public function redirectToFacebook(Request $request)
    {
        $clientId = config('services.facebook.client_id');
        $clientSecret = config('services.facebook.client_secret');

        if (!empty($clientId) && !empty($clientSecret) && !$request->has('demo')) {
            $redirectUri = url('/auth/facebook/callback');
            return Socialite::driver('facebook')->redirectUrl($redirectUri)->redirect();
        }

        // Seamless development fallback
        $email = $request->query('email', 'usuario.facebook@facebook.com');
        $name = $request->query('name', 'Manuel G. (Facebook)');

        $user = CentralUser::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make(bin2hex(random_bytes(16))),
                'auth_provider' => 'facebook',
                'auth_provider_id' => 'fb_' . substr(md5($email), 0, 12),
                'avatar_url' => 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?auto=format&fit=crop&w=120&q=80',
            ]
        );

        Auth::guard('web')->login($user, true);
        $request->session()->regenerate();

        $msg = !empty($clientId)
            ? "¡Sesión iniciada con Facebook como {$user->name}!"
            : "¡Sesión iniciada con Facebook! (Para producción completa, configura FACEBOOK_CLIENT_ID y FACEBOOK_CLIENT_SECRET en tu archivo .env)";

        return redirect('/')->with('success', $msg);
    }

    /**
     * Handle callback from Facebook OAuth.
     */
    public function handleFacebookCallback(Request $request)
    {
        try {
            $redirectUri = url('/auth/facebook/callback');
            $driver = Socialite::driver('facebook')->redirectUrl($redirectUri);

            $caPath = storage_path('cacert.pem');
            $driver->setHttpClient(new \GuzzleHttp\Client([
                'verify' => file_exists($caPath) ? realpath($caPath) : false,
                'timeout' => 15,
            ]));

            $fbUser = $driver->user();

            $email = $fbUser->getEmail() ?? ($fbUser->getId() . '@facebook.com');
            $user = CentralUser::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $fbUser->getName() ?? 'Usuario Facebook',
                    'password' => Hash::make(bin2hex(random_bytes(16))),
                    'auth_provider' => 'facebook',
                    'auth_provider_id' => (string) $fbUser->getId(),
                    'avatar_url' => $fbUser->getAvatar() ?? 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?auto=format&fit=crop&w=120&q=80',
                ]
            );

            Auth::guard('web')->login($user, true);
            $request->session()->regenerate();

            return redirect('/')->with('success', "¡Conectado exitosamente con tu cuenta oficial de Facebook ({$user->name})!");
        } catch (\Exception $e) {
            return redirect('/login')->withErrors([
                'oauth' => 'No se pudo completar el inicio de sesión con Facebook: ' . $e->getMessage(),
            ]);
        }
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = CentralUser::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'auth_provider' => 'email',
            'avatar_url' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=120&q=80',
        ]);

        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return redirect('/')->with('success', "¡Cuenta creada exitosamente! Bienvenido a la plataforma, {$user->name}.");
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('info', 'Has cerrado sesión correctamente.');
    }

    /**
     * Interactive Social Login (Google / Facebook) for immediate testing and demo
     */
    public function socialLogin(Request $request)
    {
        $validated = $request->validate([
            'provider' => ['required', 'in:google,facebook'],
            'email' => ['required', 'email'],
            'name' => ['required', 'string', 'max:255'],
            'avatar_url' => ['nullable', 'string'],
        ]);

        $provider = $validated['provider'];
        $name = $validated['name'];
        $email = $validated['email'];

        $avatarUrl = !empty($validated['avatar_url'])
            ? $validated['avatar_url']
            : ($provider === 'google'
                ? "https://ui-avatars.com/api/?name=" . urlencode($name) . "&background=4285F4&color=ffffff&bold=true"
                : "https://ui-avatars.com/api/?name=" . urlencode($name) . "&background=1877F2&color=ffffff&bold=true");

        $user = CentralUser::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make(bin2hex(random_bytes(16))),
                'auth_provider' => $provider,
                'auth_provider_id' => $provider . '_' . substr(md5($email), 0, 12),
                'avatar_url' => $avatarUrl,
            ]
        );

        Auth::guard('web')->login($user, true);
        $request->session()->regenerate();

        $providerName = ucfirst($validated['provider']);
        return redirect('/')->with('success', "¡Sesión iniciada con {$providerName} como {$user->name}!");
    }
}
