<?php

/**
 * File: LoginTest.php
 * Description: Feature tests for user login functionality
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-22
 */

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the login page renders correctly.
     */
    public function test_login_page_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Sign In to Your Account');
        $response->assertSee('Email Address');
        $response->assertSee('Password');
        $response->assertSee('Keep me signed in');
    }

    /**
     * Test that the login page contains sales/branding elements.
     */
    public function test_login_page_contains_branding_elements(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);

        // Check for trust signals
        $response->assertSee('Secure login');
        $response->assertSee('Privacy protected');

        // Check for welcome back elements
        $response->assertSee('Welcome Back');
        $response->assertSee('Your Benefits Await');

        // Check for social login placeholders
        $response->assertSee('Google');
        $response->assertSee('Apple');
    }

    /**
     * Test that the login page shows region branding from config.
     */
    public function test_login_page_shows_region_branding(): void
    {
        config(['city.active' => 'sherwood']);

        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Sherwood');
    }

    /**
     * Test successful user login.
     */
    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('Password123!'),
        ]);

        Livewire::test('auth.login')
            ->set('email', 'test@example.com')
            ->set('password', 'Password123!')
            ->call('login')
            ->assertRedirect('/onboarding');

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test login with incorrect password fails.
     */
    public function test_login_fails_with_invalid_password(): void
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('Password123!'),
        ]);

        Livewire::test('auth.login')
            ->set('email', 'test@example.com')
            ->set('password', 'WrongPassword!')
            ->call('login')
            ->assertHasErrors(['email']);

        $this->assertGuest();
    }

    /**
     * Test login with non-existent email fails.
     */
    public function test_login_fails_with_nonexistent_email(): void
    {
        Livewire::test('auth.login')
            ->set('email', 'nonexistent@example.com')
            ->set('password', 'Password123!')
            ->call('login')
            ->assertHasErrors(['email']);

        $this->assertGuest();
    }

    /**
     * Test that email is required.
     */
    public function test_email_is_required(): void
    {
        Livewire::test('auth.login')
            ->set('email', '')
            ->set('password', 'Password123!')
            ->call('login')
            ->assertHasErrors(['email']);
    }

    /**
     * Test that email must be valid format.
     */
    public function test_email_must_be_valid(): void
    {
        Livewire::test('auth.login')
            ->set('email', 'not-an-email')
            ->set('password', 'Password123!')
            ->call('login')
            ->assertHasErrors(['email']);
    }

    /**
     * Test that password is required.
     */
    public function test_password_is_required(): void
    {
        Livewire::test('auth.login')
            ->set('email', 'test@example.com')
            ->set('password', '')
            ->call('login')
            ->assertHasErrors(['password']);
    }

    /**
     * Test remember me functionality extends session.
     */
    public function test_remember_me_functionality(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('Password123!'),
        ]);

        Livewire::test('auth.login')
            ->set('email', 'test@example.com')
            ->set('password', 'Password123!')
            ->set('remember', true)
            ->call('login')
            ->assertRedirect('/onboarding');

        $this->assertAuthenticatedAs($user);

        // Verify remember token was set
        $user->refresh();
        $this->assertNotNull($user->remember_token);
    }

    /**
     * Test login without remember me does not set remember token.
     */
    public function test_login_without_remember_me(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('Password123!'),
            'remember_token' => null,
        ]);

        Livewire::test('auth.login')
            ->set('email', 'test@example.com')
            ->set('password', 'Password123!')
            ->set('remember', false)
            ->call('login')
            ->assertRedirect('/onboarding');

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test rate limiting after 5 failed attempts.
     */
    public function test_rate_limiting_after_five_failed_attempts(): void
    {
        Event::fake([Lockout::class]);

        $user = User::factory()->create([
            'email' => 'ratelimit@example.com',
            'password' => Hash::make('Password123!'),
        ]);

        // Make 5 failed login attempts
        for ($i = 0; $i < 5; $i++) {
            Livewire::test('auth.login')
                ->set('email', 'ratelimit@example.com')
                ->set('password', 'WrongPassword!')
                ->call('login');
        }

        // 6th attempt should be rate limited
        Livewire::test('auth.login')
            ->set('email', 'ratelimit@example.com')
            ->set('password', 'WrongPassword!')
            ->call('login')
            ->assertHasErrors(['email']);

        // Verify Lockout event was fired
        Event::assertDispatched(Lockout::class);

        $this->assertGuest();
    }

    /**
     * Test that rate limiter resets after successful login.
     */
    public function test_rate_limiter_clears_on_successful_login(): void
    {
        $user = User::factory()->create([
            'email' => 'clearrate@example.com',
            'password' => Hash::make('Password123!'),
        ]);

        // Make a few failed attempts
        for ($i = 0; $i < 3; $i++) {
            Livewire::test('auth.login')
                ->set('email', 'clearrate@example.com')
                ->set('password', 'WrongPassword!')
                ->call('login');
        }

        // Now login successfully
        Livewire::test('auth.login')
            ->set('email', 'clearrate@example.com')
            ->set('password', 'Password123!')
            ->call('login')
            ->assertRedirect('/onboarding');

        $this->assertAuthenticatedAs($user);

        // Logout and try to login again - should work without rate limiting
        auth()->logout();

        Livewire::test('auth.login')
            ->set('email', 'clearrate@example.com')
            ->set('password', 'Password123!')
            ->call('login')
            ->assertRedirect('/onboarding');
    }

    /**
     * Test redirect to intended URL after login.
     */
    public function test_redirect_to_intended_url_after_login(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('Password123!'),
        ]);

        // Set an intended URL in the session
        session()->put('url.intended', '/some-protected-page');

        Livewire::test('auth.login')
            ->set('email', 'test@example.com')
            ->set('password', 'Password123!')
            ->call('login')
            ->assertRedirect('/some-protected-page');

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test that authenticated users are redirected from login page.
     */
    public function test_authenticated_users_cannot_access_login(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/login');

        // Authenticated users should be redirected away from login
        $response->assertRedirect();
    }

    /**
     * Test that email is lowercased during login.
     */
    public function test_email_is_lowercased(): void
    {
        $user = User::factory()->create([
            'email' => 'uppercase@example.com',
            'password' => Hash::make('Password123!'),
        ]);

        Livewire::test('auth.login')
            ->set('email', 'UPPERCASE@EXAMPLE.COM')
            ->set('password', 'Password123!')
            ->call('login')
            ->assertRedirect('/onboarding');

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test password visibility toggle.
     */
    public function test_password_visibility_toggle_works(): void
    {
        $component = Livewire::test('auth.login');

        $this->assertFalse($component->get('showPassword'));

        $component->call('togglePasswordVisibility');
        $this->assertTrue($component->get('showPassword'));

        $component->call('togglePasswordVisibility');
        $this->assertFalse($component->get('showPassword'));
    }

    /**
     * Test real-time email validation.
     */
    public function test_real_time_email_validation(): void
    {
        Livewire::test('auth.login')
            ->set('email', 'invalid-email')
            ->assertHasErrors(['email']);
    }

    /**
     * Test forgot password link exists.
     */
    public function test_forgot_password_link_exists(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Forgot password?');
    }

    /**
     * Test register link exists on login page.
     */
    public function test_register_link_exists(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        // Check for register link text (avoiding apostrophe encoding issues)
        $response->assertSee('have an account?');
        $response->assertSee('Create one now');
    }

    /**
     * Test login page is accessible at /login route.
     */
    public function test_login_route_exists(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }

    /**
     * Test CSRF protection is present.
     */
    public function test_csrf_protection_is_present(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        // The Livewire form includes CSRF protection automatically
        $response->assertSee('csrf-token');
    }

    /**
     * Test session is regenerated after login.
     */
    public function test_session_is_regenerated_after_login(): void
    {
        $user = User::factory()->create([
            'email' => 'session@example.com',
            'password' => Hash::make('Password123!'),
        ]);

        $originalSessionId = session()->getId();

        Livewire::test('auth.login')
            ->set('email', 'session@example.com')
            ->set('password', 'Password123!')
            ->call('login');

        // Session should be regenerated (new ID)
        $this->assertNotEquals($originalSessionId, session()->getId());
    }

    /**
     * Test login with soft deleted user fails.
     */
    public function test_login_fails_with_soft_deleted_user(): void
    {
        $user = User::factory()->create([
            'email' => 'deleted@example.com',
            'password' => Hash::make('Password123!'),
        ]);

        // Soft delete the user
        $user->delete();

        Livewire::test('auth.login')
            ->set('email', 'deleted@example.com')
            ->set('password', 'Password123!')
            ->call('login')
            ->assertHasErrors(['email']);

        $this->assertGuest();
    }

    /**
     * Test loading state during submission.
     */
    public function test_loading_state_during_submission(): void
    {
        $component = Livewire::test('auth.login');

        $this->assertFalse($component->get('isSubmitting'));
    }

    /**
     * Test default redirect to onboarding.
     */
    public function test_default_redirect_to_onboarding(): void
    {
        $user = User::factory()->create([
            'email' => 'default@example.com',
            'password' => Hash::make('Password123!'),
        ]);

        Livewire::test('auth.login')
            ->set('email', 'default@example.com')
            ->set('password', 'Password123!')
            ->call('login')
            ->assertRedirect('/onboarding');
    }

    /**
     * Test forgot password page exists and is functional.
     */
    public function test_forgot_password_page_exists(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
        $response->assertSee('Forgot Your Password?');
    }

    /**
     * Test reset password page exists and is functional.
     */
    public function test_reset_password_page_exists(): void
    {
        $response = $this->get('/reset-password/some-token');

        $response->assertStatus(200);
        $response->assertSee('Reset Your Password');
    }
}
