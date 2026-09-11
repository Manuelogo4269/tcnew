<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\CentralUser;
use App\Models\Product;
use App\Models\Tenant;
use Tests\TestCase;

class CentralPortalAndAuthTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        \Illuminate\Support\Facades\Cache::flush();
    }

    protected function tearDown(): void
    {
        $tenant = Tenant::find('conceptos7');
        if ($tenant) {
            $tenant->run(function () {
                Product::whereIn('slug', [
                    'collar-choker-eslabones-oro-18k',
                    'vestido-midi-satinado-espalda-abierta',
                    'zapatillas-tacon-fino-tira-minimalista',
                ])->delete();
            });
        }
        parent::tearDown();
    }

    public function test_central_portal_displays_categorized_enterprises(): void
    {
        $response = $this->get('http://localhost/');
        $response->assertStatus(200);

        // Verify categorized enterprises section
        $response->assertSee('Empresas Disponibles en la App');
        $response->assertSee('✦ Todas las Empresas');
        $response->assertSee('Moda y Lujo');

        // Verify available enterprises
        $response->assertSee('D & R CONCEPTOS');
        $response->assertSee('Entrar a la Tienda');
    }

    public function test_global_search_across_all_stores(): void
    {
        $tenant = Tenant::find('conceptos7');
        if ($tenant) {
            $tenant->run(function () {
                $cat = Category::firstOrCreate(['slug' => 'joyeria-y-accesorios'], ['name' => 'Joyería y Accesorio ✨']);
                Product::firstOrCreate(
                    ['slug' => 'collar-choker-eslabones-oro-18k'],
                    [
                        'category_id' => $cat->id,
                        'name' => 'Collar Choker de Eslabones en Baño de Oro 18K',
                        'price' => 590.00,
                        'stock' => 15,
                        'is_active' => true,
                    ]
                );
                Product::firstOrCreate(
                    ['slug' => 'vestido-midi-satinado-espalda-abierta'],
                    [
                        'category_id' => $cat->id,
                        'name' => 'Vestido Midi Satinado con Espalda Abierta',
                        'price' => 890.00,
                        'stock' => 20,
                        'is_active' => true,
                    ]
                );
                Product::firstOrCreate(
                    ['slug' => 'zapatillas-tacon-fino-tira-minimalista'],
                    [
                        'category_id' => $cat->id,
                        'name' => 'Zapatillas de Tacón Fino y Tira Minimalista',
                        'price' => 850.00,
                        'stock' => 25,
                        'is_active' => true,
                    ]
                );
            });
        }

        // 1. Search for jewelry product
        $responseJewelry = $this->get('http://localhost/?q=oro');
        $responseJewelry->assertStatus(200);
        $responseJewelry->assertSee('Resultados para "oro"', false);
        $responseJewelry->assertSee('D & R CONCEPTOS');
        $responseJewelry->assertSee('Collar Choker');

        // 2. Search for clothing product
        $responseDress = $this->get('http://localhost/?q=vestido');
        $responseDress->assertStatus(200);
        $responseDress->assertSee('D & R CONCEPTOS');
        $responseDress->assertSee('Vestido Midi Satinado');

        // 3. Search for shoes/footwear
        $responseShoes = $this->get('http://localhost/?q=zapatillas');
        $responseShoes->assertStatus(200);
        $responseShoes->assertSee('Zapatillas de Tacón Fino');

        // 4. API Live Search endpoint
        $apiResponse = $this->getJson('http://localhost/api/global-search?q=joyeria');
        $apiResponse->assertStatus(200)
            ->assertJsonPath('count', fn ($count) => $count >= 1);
    }

    public function test_social_and_email_authentication_alternatives(): void
    {
        // 1. Check Login Page displays Google, Facebook, and Email options
        $loginPage = $this->get('http://localhost/login');
        $loginPage->assertStatus(200);
        $loginPage->assertSee('Continuar con Google');
        $loginPage->assertSee('Continuar con Facebook');
        $loginPage->assertSee('Iniciar Sesión con Correo');

        // 2. Google Authentication (Redirects to Google OAuth consent screen when credentials configured, or ?demo=1 for testing)
        $googleResponse = $this->get('http://localhost/auth/google?demo=1');
        $googleResponse->assertRedirect('/');
        $this->assertAuthenticatedAs(
            CentralUser::where('auth_provider', 'google')->first(),
            'web'
        );

        // 3. Facebook Authentication
        $fbResponse = $this->get('http://localhost/auth/facebook');
        $fbResponse->assertRedirect('/');
        $this->assertAuthenticatedAs(
            CentralUser::where('auth_provider', 'facebook')->first(),
            'web'
        );

        // 4. Email Registration
        $email = 'nuevo_usuario_' . time() . '@correo.com';
        $registerResponse = $this->post('http://localhost/register', [
            'name' => 'Usuario Nuevo',
            'email' => $email,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $registerResponse->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'email' => $email,
            'auth_provider' => 'email',
        ]);

        // 5. Logout
        $logoutResponse = $this->get('http://localhost/logout');
        $logoutResponse->assertRedirect('/');
        $this->assertGuest('web');
    }

    public function test_socialite_google_and_facebook_callbacks(): void
    {
        // 1. Mock Google OAuth User from Socialite
        $googleUser = \Mockery::mock(\Laravel\Socialite\Two\User::class);
        $googleUser->shouldReceive('getId')->andReturn('google_987654321');
        $googleUser->shouldReceive('getName')->andReturn('Carlos Mendoza Google');
        $googleUser->shouldReceive('getNickname')->andReturn('carlosm');
        $googleUser->shouldReceive('getEmail')->andReturn('carlos.mendoza@gmail.com');
        $googleUser->shouldReceive('getAvatar')->andReturn('https://lh3.googleusercontent.com/photo.jpg');

        $googleProvider = \Mockery::mock(\Laravel\Socialite\Two\GoogleProvider::class);
        $googleProvider->shouldReceive('redirectUrl')->andReturnSelf();
        $googleProvider->shouldReceive('setHttpClient')->andReturnSelf();
        $googleProvider->shouldReceive('user')->andReturn($googleUser);

        \Laravel\Socialite\Facades\Socialite::shouldReceive('driver')->with('google')->andReturn($googleProvider);

        $googleCallbackResponse = $this->get('http://localhost/auth/google/callback');
        $googleCallbackResponse->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'email' => 'carlos.mendoza@gmail.com',
            'auth_provider' => 'google',
            'auth_provider_id' => 'google_987654321',
        ]);

        // 2. Mock Facebook OAuth User from Socialite
        $fbUser = \Mockery::mock(\Laravel\Socialite\Two\User::class);
        $fbUser->shouldReceive('getId')->andReturn('fb_1234567890');
        $fbUser->shouldReceive('getName')->andReturn('Valeria Torres Facebook');
        $fbUser->shouldReceive('getEmail')->andReturn('valeria.torres@facebook.com');
        $fbUser->shouldReceive('getAvatar')->andReturn('https://graph.facebook.com/picture.jpg');

        $fbProvider = \Mockery::mock(\Laravel\Socialite\Two\FacebookProvider::class);
        $fbProvider->shouldReceive('redirectUrl')->andReturnSelf();
        $fbProvider->shouldReceive('setHttpClient')->andReturnSelf();
        $fbProvider->shouldReceive('user')->andReturn($fbUser);

        \Laravel\Socialite\Facades\Socialite::shouldReceive('driver')->with('facebook')->andReturn($fbProvider);

        $fbCallbackResponse = $this->get('http://localhost/auth/facebook/callback');
        $fbCallbackResponse->assertRedirect('/');
        $this->assertDatabaseHas('users', [
            'email' => 'valeria.torres@facebook.com',
            'auth_provider' => 'facebook',
            'auth_provider_id' => 'fb_1234567890',
        ]);
    }

    public function test_interactive_social_login_without_avatar_url(): void
    {
        $response = $this->post('http://localhost/auth/social/login', [
            'provider' => 'google',
            'name' => 'Manuel Alejandro Moreno de la Cruz',
            'email' => 'manuelmorenocruz1307@gmail.com',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated('web');
        $this->assertDatabaseHas('users', [
            'email' => 'manuelmorenocruz1307@gmail.com',
            'name' => 'Manuel Alejandro Moreno de la Cruz',
            'auth_provider' => 'google',
        ]);
    }

    public function test_home_portal_does_not_display_super_admin_and_relocated_to_plans(): void
    {
        $homeResponse = $this->get('http://localhost/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertDontSee('Super Admin');
        $homeResponse->assertDontSee('btn-admin-panel');
        $homeResponse->assertDontSee('href="/admin"', false);

        $plansResponse = $this->get('http://localhost/planes');
        $plansResponse->assertStatus(200);
        $plansResponse->assertSee('Super Admin');
        $plansResponse->assertSee('/admin');
    }

    public function test_home_portal_does_not_display_static_search_chips(): void
    {
        $response = $this->get('http://localhost/');
        $response->assertStatus(200);
        $response->assertDontSee('Búsquedas de Zacatecas:');
        $response->assertDontSee('popular-tags-row');
        $response->assertSee('userSearchHistoryContainer');
    }

    public function test_google_token_authentication_endpoint(): void
    {
        $payload = [
            'email' => 'google_jwt_test@gmail.com',
            'name' => 'Manuel JWT Test',
            'sub' => 'goog_jwt_9988776655',
            'picture' => 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=120&q=80',
        ];

        $header = rtrim(strtr(base64_encode(json_encode(['alg' => 'RS256', 'typ' => 'JWT'])), '+/', '-_'), '=');
        $body = rtrim(strtr(base64_encode(json_encode($payload)), '+/', '-_'), '=');
        $dummyJwt = $header . '.' . $body . '.mock_signature';

        $response = $this->postJson('http://localhost/auth/google/token', [
            'credential' => $dummyJwt,
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        $this->assertAuthenticated('web');
        $this->assertDatabaseHas('users', [
            'email' => 'google_jwt_test@gmail.com',
            'name' => 'Manuel JWT Test',
            'auth_provider' => 'google',
        ]);
    }

    public function test_navigation_responsive_visibility_phone_vs_web(): void
    {
        $response = $this->get('http://localhost/');
        $response->assertStatus(200);

        // Verify mobile-bottom-nav is hidden on desktop web by default
        $response->assertSee('.mobile-bottom-nav {', false);
        $response->assertSee('display: none; /* Oculto en la página web de escritorio */', false);

        // Verify top segmented tabs are hidden on phone
        $response->assertSee('@media (max-width: 768px)', false);
        $response->assertSee('.main-tab-nav-wrapper {', false);
        $response->assertSee('display: none !important;', false);

        // Verify desktop explicit rule
        $response->assertSee('@media (min-width: 769px)', false);
    }

    public function test_walking_route_api_endpoint(): void
    {
        $response = $this->get('/api/walking-route?coords=-102.5724,22.7753;-102.5720,22.7758;-102.5745,22.7712');
        $response->assertStatus(200);
        $data = $response->json();
        $this->assertTrue(in_array($data['code'] ?? '', ['Ok', 'Fallback']));
    }
}

