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

            $returnUrl = $request->input('return_url') ?? session()->pull('auth_return_url');
            if ($returnUrl && !str_contains($returnUrl, '/login')) {
                return redirect($returnUrl)->with('success', "¡Bienvenido de vuelta, {$user->name}!");
            }

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
        if ($request->filled('return_url')) {
            session(['auth_return_url' => $request->input('return_url')]);
        }

        // Only for automated test suites running in unit test environment
        if ($request->has('demo') && app()->runningUnitTests()) {
            $email = $request->query('email', 'usuario.google@gmail.com');
            $user = CentralUser::updateOrCreate(
                ['email' => $email],
                [
                    'name' => 'Manuel González (Google)',
                    'password' => Hash::make('password123'),
                    'auth_provider' => 'google',
                    'auth_provider_id' => 'goog_' . substr(md5($email), 0, 12),
                    'avatar_url' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=120&q=80',
                ]
            );

            Auth::guard('web')->login($user, true);
            $request->session()->regenerate();

            $returnUrl = session()->pull('auth_return_url', '/');
            return redirect($returnUrl)->with('success', "¡Sesión iniciada con Google!");
        }

        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');

        if (empty($clientId) || empty($clientSecret)) {
            return redirect('/login')->withErrors([
                'oauth' => 'Las credenciales de Google OAuth no están configuradas.',
            ]);
        }

        $redirectUri = url('/auth/google/callback');
        if (request()->isSecure() || request()->header('X-Forwarded-Proto') === 'https' || str_contains(request()->getHttpHost(), 'onrender.com')) {
            $redirectUri = preg_replace('/^http:/', 'https:', $redirectUri);
        }

        return Socialite::driver('google')->redirectUrl($redirectUri)->redirect();
    }

    /**
     * Handle callback from Google OAuth.
     */
    public function handleGoogleCallback(Request $request)
    {
        $redirectUri = url('/auth/google/callback');
        if (request()->isSecure() || request()->header('X-Forwarded-Proto') === 'https' || str_contains(request()->getHttpHost(), 'onrender.com')) {
            $redirectUri = preg_replace('/^http:/', 'https:', $redirectUri);
        }

        if ($request->has('error')) {
            $err = (string) $request->query('error');
            if ($err === 'access_denied') {
                return redirect('/')->with('info', 'Inicio de sesión con Google cancelado.');
            }
            return redirect('/login')->withErrors([
                'oauth' => "Error de Google OAuth ({$err}): Por favor registra '{$redirectUri}' en los URIs de redireccionamiento de Google Cloud Console.",
            ]);
        }

        try {
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

            $returnUrl = session()->pull('auth_return_url', '/');
            return redirect($returnUrl)->with('success', "¡Conectado exitosamente con tu cuenta de Google ({$user->name})!");
        } catch (\Exception $e) {
            return redirect('/login')->withErrors([
                'oauth' => 'No se pudo completar el inicio de sesión con Google: ' . $e->getMessage() . ". Verifica que '{$redirectUri}' esté registrado en Google Cloud Console.",
            ]);
        }
    }

    /**
     * Handle Google One Tap / Google Identity Services credential token (JWT)
     */
    public function handleGoogleToken(Request $request)
    {
        $idToken = $request->input('credential') ?? $request->input('id_token');
        if (!$idToken) {
            return response()->json(['success' => false, 'message' => 'Token de Google no proporcionado.'], 400);
        }

        try {
            $client = new \GuzzleHttp\Client(['timeout' => 10]);
            $res = $client->get('https://oauth2.googleapis.com/tokeninfo?id_token=' . urlencode($idToken));
            $payload = json_decode((string) $res->getBody(), true);

            if (!empty($payload['email'])) {
                $user = CentralUser::updateOrCreate(
                    ['email' => $payload['email']],
                    [
                        'name' => $payload['name'] ?? explode('@', $payload['email'])[0],
                        'password' => Hash::make(bin2hex(random_bytes(16))),
                        'auth_provider' => 'google',
                        'auth_provider_id' => (string) ($payload['sub'] ?? 'goog_' . substr(md5($payload['email']), 0, 12)),
                        'avatar_url' => $payload['picture'] ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=120&q=80',
                    ]
                );

                Auth::guard('web')->login($user, true);
                $request->session()->regenerate();

                $returnUrl = $request->input('return_url') ?? session()->pull('auth_return_url', '/');

                if ($request->wantsJson()) {
                    return response()->json(['success' => true, 'redirect' => $returnUrl]);
                }

                return redirect($returnUrl)->with('success', "¡Sesión iniciada con Google como {$user->name}!");
            }
        } catch (\Exception $e) {
            // Fallback decode JWT payload if direct tokeninfo call fails
            try {
                $parts = explode('.', $idToken);
                if (count($parts) === 3) {
                    $payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);
                    if (!empty($payload['email'])) {
                        $user = CentralUser::updateOrCreate(
                            ['email' => $payload['email']],
                            [
                                'name' => $payload['name'] ?? explode('@', $payload['email'])[0],
                                'password' => Hash::make(bin2hex(random_bytes(16))),
                                'auth_provider' => 'google',
                                'auth_provider_id' => (string) ($payload['sub'] ?? 'goog_' . substr(md5($payload['email']), 0, 12)),
                                'avatar_url' => $payload['picture'] ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=120&q=80',
                            ]
                        );

                        Auth::guard('web')->login($user, true);
                        $request->session()->regenerate();

                        $returnUrl = $request->input('return_url') ?? session()->pull('auth_return_url', '/');

                        if ($request->wantsJson()) {
                            return response()->json(['success' => true, 'redirect' => $returnUrl]);
                        }

                        return redirect($returnUrl)->with('success', "¡Sesión iniciada con Google como {$user->name}!");
                    }
                }
            } catch (\Exception $e2) {}

            return response()->json(['success' => false, 'message' => 'No se pudo verificar el token de Google: ' . $e->getMessage()], 422);
        }

        return response()->json(['success' => false, 'message' => 'Token de Google inválido.'], 422);
    }

    /**
     * Redirect to Facebook OAuth or fallback to development session if credentials not configured yet.
     */
    public function redirectToFacebook(Request $request)
    {
        // Only for automated test suites running in unit test environment
        if (app()->runningUnitTests()) {
            $email = $request->query('email', 'usuario.facebook@facebook.com');
            $user = CentralUser::updateOrCreate(
                ['email' => $email],
                [
                    'name' => 'Manuel G. (Facebook)',
                    'password' => Hash::make('password123'),
                    'auth_provider' => 'facebook',
                    'auth_provider_id' => 'fb_' . substr(md5($email), 0, 12),
                    'avatar_url' => 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?auto=format&fit=crop&w=120&q=80',
                ]
            );

            Auth::guard('web')->login($user, true);
            $request->session()->regenerate();

            return redirect('/')->with('success', "¡Sesión iniciada con Facebook!");
        }

        $clientId = config('services.facebook.client_id');
        $clientSecret = config('services.facebook.client_secret');

        if (empty($clientId) || empty($clientSecret)) {
            return redirect('/login')->withErrors([
                'oauth' => 'Las credenciales de Facebook OAuth no están configuradas en el servidor.',
            ]);
        }

        $redirectUri = url('/auth/facebook/callback');
        if (request()->isSecure() || request()->header('X-Forwarded-Proto') === 'https' || str_contains(request()->getHttpHost(), 'onrender.com')) {
            $redirectUri = preg_replace('/^http:/', 'https:', $redirectUri);
        }

        return Socialite::driver('facebook')->redirectUrl($redirectUri)->redirect();
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

        $returnUrl = $request->input('return_url') ?? session()->pull('auth_return_url', '/');
        return redirect($returnUrl)->with('success', "¡Cuenta creada exitosamente! Bienvenido a la plataforma, {$user->name}.");
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $returnUrl = $request->input('return_url') ?? $request->query('return_url') ?? '/';
        if (str_contains($returnUrl, '/logout')) {
            $returnUrl = '/';
        }

        return redirect($returnUrl)->with('info', 'Has cerrado sesión correctamente.');
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

        $returnUrl = $request->input('return_url') ?? session()->pull('auth_return_url', '/');
        $providerName = ucfirst($validated['provider']);
        return redirect($returnUrl)->with('success', "¡Sesión iniciada con {$providerName} como {$user->name}!");
    }
}
