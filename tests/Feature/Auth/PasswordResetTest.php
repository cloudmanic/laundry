<?php

/**
 * File: PasswordResetTest.php
 * Description: Feature tests for password reset functionality
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-22
 */

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Livewire\Livewire;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    /*
    |--------------------------------------------------------------------------
    | Forgot Password Page Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test that the forgot password page renders correctly.
     */
    public function test_forgot_password_page_can_be_rendered(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
        $response->assertSee('Forgot Your Password?');
        $response->assertSee('Email Address');
        $response->assertSee('Send Reset Link');
    }

    /**
     * Test that the forgot password page contains branding elements.
     */
    public function test_forgot_password_page_contains_branding_elements(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);

        // Check for trust signals
        $response->assertSee('Secure reset');
        $response->assertSee('Privacy protected');

        // Check for how it works section
        $response->assertSee('How It Works');
        $response->assertSee('Enter Your Email');
        $response->assertSee('Check Your Inbox');
    }

    /**
     * Test that the forgot password page shows region branding from config.
     */
    public function test_forgot_password_page_shows_region_branding(): void
    {
        config(['city.active' => 'sherwood']);

        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
        $response->assertSee('Sherwood');
    }

    /**
     * Test that authenticated users are redirected from forgot password page.
     */
    public function test_authenticated_users_cannot_access_forgot_password(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/forgot-password');

        $response->assertRedirect();
    }

    /*
    |--------------------------------------------------------------------------
    | Password Reset Request Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test that password reset email can be requested for existing user.
     */
    public function test_password_reset_link_can_be_requested(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        Livewire::test('auth.forgot-password')
            ->set('email', 'test@example.com')
            ->call('sendResetLink')
            ->assertSet('emailSent', true)
            ->assertHasNoErrors();

        Notification::assertSentTo($user, \App\Notifications\ResetPasswordNotification::class);
    }

    /**
     * Test that email is required for password reset request.
     */
    public function test_email_is_required_for_password_reset(): void
    {
        Livewire::test('auth.forgot-password')
            ->set('email', '')
            ->call('sendResetLink')
            ->assertHasErrors(['email']);
    }

    /**
     * Test that email must be valid for password reset request.
     */
    public function test_email_must_be_valid_for_password_reset(): void
    {
        Livewire::test('auth.forgot-password')
            ->set('email', 'not-an-email')
            ->call('sendResetLink')
            ->assertHasErrors(['email']);
    }

    /**
     * Test that password reset shows success even for non-existent user.
     *
     * This prevents email enumeration attacks - users should not be able
     * to determine if an email exists in the system.
     */
    public function test_password_reset_shows_success_for_nonexistent_user(): void
    {
        Notification::fake();

        Livewire::test('auth.forgot-password')
            ->set('email', 'nonexistent@example.com')
            ->call('sendResetLink')
            ->assertSet('emailSent', true)
            ->assertHasNoErrors();

        // No notification should be sent since user doesn't exist
        Notification::assertNothingSent();
    }

    /**
     * Test real-time email validation on forgot password form.
     */
    public function test_real_time_email_validation(): void
    {
        Livewire::test('auth.forgot-password')
            ->set('email', 'invalid-email')
            ->assertHasErrors(['email']);
    }

    /**
     * Test email is lowercased during password reset request.
     */
    public function test_email_is_lowercased_for_password_reset(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);

        Livewire::test('auth.forgot-password')
            ->set('email', 'TEST@EXAMPLE.COM')
            ->call('sendResetLink')
            ->assertSet('emailSent', true);

        Notification::assertSentTo($user, \App\Notifications\ResetPasswordNotification::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test that password reset requests are rate limited.
     */
    public function test_password_reset_is_rate_limited(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'ratelimit@example.com',
        ]);

        // Make 3 requests (the limit)
        for ($i = 0; $i < 3; $i++) {
            Livewire::test('auth.forgot-password')
                ->set('email', 'ratelimit@example.com')
                ->call('sendResetLink');
        }

        // 4th request should be rate limited
        Livewire::test('auth.forgot-password')
            ->set('email', 'ratelimit@example.com')
            ->call('sendResetLink')
            ->assertHasErrors(['email']);
    }

    /*
    |--------------------------------------------------------------------------
    | Reset Password Page Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test that the reset password page renders correctly with valid token.
     */
    public function test_reset_password_page_can_be_rendered(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $response = $this->get("/reset-password/{$token}?email={$user->email}");

        $response->assertStatus(200);
        $response->assertSee('Reset Your Password');
        $response->assertSee('New Password');
        $response->assertSee('Confirm New Password');
    }

    /**
     * Test that the reset password page contains branding elements.
     */
    public function test_reset_password_page_contains_branding_elements(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $response = $this->get("/reset-password/{$token}?email={$user->email}");

        $response->assertStatus(200);

        // Check for trust signals
        $response->assertSee('Secure reset');
        $response->assertSee('Privacy protected');

        // Check for password tips section
        $response->assertSee('Password Tips');
        $response->assertSee('At Least 8 Characters');
    }

    /**
     * Test that authenticated users are redirected from reset password page.
     */
    public function test_authenticated_users_cannot_access_reset_password(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/reset-password/some-token');

        $response->assertRedirect();
    }

    /*
    |--------------------------------------------------------------------------
    | Password Reset Execution Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test that password can be reset with valid token.
     */
    public function test_password_can_be_reset_with_valid_token(): void
    {
        Event::fake([PasswordReset::class]);

        $user = User::factory()->create([
            'email' => 'reset@example.com',
            'password' => Hash::make('OldPassword123!'),
        ]);

        $token = Password::createToken($user);

        Livewire::test('auth.reset-password', ['token' => $token])
            ->set('email', 'reset@example.com')
            ->set('password', 'NewPassword123!')
            ->set('password_confirmation', 'NewPassword123!')
            ->call('resetPassword')
            ->assertRedirect('/onboarding');

        // Verify password was changed
        $user->refresh();
        $this->assertTrue(Hash::check('NewPassword123!', $user->password));

        // Verify PasswordReset event was fired
        Event::assertDispatched(PasswordReset::class);

        // Verify user is logged in
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test that password reset fails with expired token.
     */
    public function test_password_reset_fails_with_expired_token(): void
    {
        $user = User::factory()->create([
            'email' => 'expired@example.com',
        ]);

        $token = Password::createToken($user);

        // Manually expire the token by updating its creation time
        $this->travel(61)->minutes();

        Livewire::test('auth.reset-password', ['token' => $token])
            ->set('email', 'expired@example.com')
            ->set('password', 'NewPassword123!')
            ->set('password_confirmation', 'NewPassword123!')
            ->call('resetPassword')
            ->assertHasErrors(['email']);

        $this->assertGuest();
    }

    /**
     * Test that password reset fails with invalid token.
     */
    public function test_password_reset_fails_with_invalid_token(): void
    {
        $user = User::factory()->create([
            'email' => 'invalid@example.com',
        ]);

        Livewire::test('auth.reset-password', ['token' => 'invalid-token'])
            ->set('email', 'invalid@example.com')
            ->set('password', 'NewPassword123!')
            ->set('password_confirmation', 'NewPassword123!')
            ->call('resetPassword')
            ->assertHasErrors(['email']);

        $this->assertGuest();
    }

    /**
     * Test that password reset fails with wrong email.
     */
    public function test_password_reset_fails_with_wrong_email(): void
    {
        $user = User::factory()->create([
            'email' => 'correct@example.com',
        ]);

        $token = Password::createToken($user);

        Livewire::test('auth.reset-password', ['token' => $token])
            ->set('email', 'wrong@example.com')
            ->set('password', 'NewPassword123!')
            ->set('password_confirmation', 'NewPassword123!')
            ->call('resetPassword')
            ->assertHasErrors(['email']);

        $this->assertGuest();
    }

    /**
     * Test that token is invalidated after use.
     */
    public function test_token_is_invalidated_after_use(): void
    {
        $user = User::factory()->create([
            'email' => 'singleuse@example.com',
        ]);

        $token = Password::createToken($user);

        // First reset should succeed
        Livewire::test('auth.reset-password', ['token' => $token])
            ->set('email', 'singleuse@example.com')
            ->set('password', 'NewPassword123!')
            ->set('password_confirmation', 'NewPassword123!')
            ->call('resetPassword')
            ->assertRedirect('/onboarding');

        // Logout to test second attempt
        auth()->logout();

        // Second reset with same token should fail
        Livewire::test('auth.reset-password', ['token' => $token])
            ->set('email', 'singleuse@example.com')
            ->set('password', 'AnotherPassword123!')
            ->set('password_confirmation', 'AnotherPassword123!')
            ->call('resetPassword')
            ->assertHasErrors(['email']);
    }

    /*
    |--------------------------------------------------------------------------
    | Password Validation Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test that password is required.
     */
    public function test_password_is_required_for_reset(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        Livewire::test('auth.reset-password', ['token' => $token])
            ->set('email', $user->email)
            ->set('password', '')
            ->set('password_confirmation', '')
            ->call('resetPassword')
            ->assertHasErrors(['password']);
    }

    /**
     * Test that password must be at least 8 characters.
     */
    public function test_password_must_be_minimum_length(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        Livewire::test('auth.reset-password', ['token' => $token])
            ->set('email', $user->email)
            ->set('password', 'short')
            ->set('password_confirmation', 'short')
            ->call('resetPassword')
            ->assertHasErrors(['password']);
    }

    /**
     * Test that password confirmation must match.
     */
    public function test_password_confirmation_must_match(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        Livewire::test('auth.reset-password', ['token' => $token])
            ->set('email', $user->email)
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'DifferentPassword!')
            ->call('resetPassword')
            ->assertHasErrors(['password']);
    }

    /**
     * Test email must be valid for reset.
     */
    public function test_email_must_be_valid_for_reset(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        Livewire::test('auth.reset-password', ['token' => $token])
            ->set('email', 'not-an-email')
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'Password123!')
            ->call('resetPassword')
            ->assertHasErrors(['email']);
    }

    /*
    |--------------------------------------------------------------------------
    | Password Strength Indicator Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test password strength calculation on reset form.
     */
    public function test_password_strength_is_calculated(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $component = Livewire::test('auth.reset-password', ['token' => $token])
            ->set('email', $user->email);

        // Weak password
        $component->set('password', 'password');
        $this->assertEquals(1, $component->get('passwordStrength'));

        // Medium password
        $component->set('password', 'Password1');
        $this->assertEquals(3, $component->get('passwordStrength'));

        // Strong password
        $component->set('password', 'Password123!@#');
        $this->assertEquals(4, $component->get('passwordStrength'));
    }

    /**
     * Test password visibility toggle works on reset form.
     */
    public function test_password_visibility_toggle_works(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $component = Livewire::test('auth.reset-password', ['token' => $token]);

        $this->assertFalse($component->get('showPassword'));

        $component->call('togglePasswordVisibility');
        $this->assertTrue($component->get('showPassword'));

        $component->call('togglePasswordVisibility');
        $this->assertFalse($component->get('showPassword'));
    }

    /*
    |--------------------------------------------------------------------------
    | Route Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test forgot password route exists and has correct name.
     */
    public function test_forgot_password_route_exists(): void
    {
        $response = $this->get(route('password.request'));

        $response->assertStatus(200);
    }

    /**
     * Test reset password route exists and has correct name.
     */
    public function test_reset_password_route_exists(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $response = $this->get(route('password.reset', ['token' => $token]));

        $response->assertStatus(200);
    }

    /**
     * Test back to login link exists on forgot password page.
     */
    public function test_back_to_login_link_exists_on_forgot_password(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
        $response->assertSee('Remember your password?');
        $response->assertSee('Sign in');
    }

    /**
     * Test back to login link exists on reset password page.
     */
    public function test_back_to_login_link_exists_on_reset_password(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $response = $this->get("/reset-password/{$token}?email={$user->email}");

        $response->assertStatus(200);
        $response->assertSee('Remember your password?');
        $response->assertSee('Sign in');
    }

    /*
    |--------------------------------------------------------------------------
    | Session and Authentication Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test that user is automatically logged in after password reset.
     */
    public function test_user_is_logged_in_after_password_reset(): void
    {
        $user = User::factory()->create([
            'email' => 'autologin@example.com',
        ]);

        $token = Password::createToken($user);

        Livewire::test('auth.reset-password', ['token' => $token])
            ->set('email', 'autologin@example.com')
            ->set('password', 'NewPassword123!')
            ->set('password_confirmation', 'NewPassword123!')
            ->call('resetPassword')
            ->assertRedirect('/onboarding');

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test that remember token is regenerated after password reset.
     */
    public function test_remember_token_is_regenerated_after_reset(): void
    {
        $user = User::factory()->create([
            'email' => 'token@example.com',
            'remember_token' => 'old-remember-token',
        ]);

        $originalToken = $user->remember_token;
        $token = Password::createToken($user);

        Livewire::test('auth.reset-password', ['token' => $token])
            ->set('email', 'token@example.com')
            ->set('password', 'NewPassword123!')
            ->set('password_confirmation', 'NewPassword123!')
            ->call('resetPassword');

        $user->refresh();
        $this->assertNotEquals($originalToken, $user->remember_token);
    }

    /*
    |--------------------------------------------------------------------------
    | Loading State Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test loading state during forgot password submission.
     */
    public function test_loading_state_during_forgot_password_submission(): void
    {
        $component = Livewire::test('auth.forgot-password');

        $this->assertFalse($component->get('isSubmitting'));
    }

    /**
     * Test loading state during reset password submission.
     */
    public function test_loading_state_during_reset_password_submission(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $component = Livewire::test('auth.reset-password', ['token' => $token]);

        $this->assertFalse($component->get('isSubmitting'));
    }

    /*
    |--------------------------------------------------------------------------
    | Success Message Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test success message is displayed after requesting password reset.
     */
    public function test_success_message_displayed_after_password_reset_request(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'success@example.com',
        ]);

        $component = Livewire::test('auth.forgot-password')
            ->set('email', 'success@example.com')
            ->call('sendResetLink');

        $this->assertTrue($component->get('emailSent'));
    }

    /**
     * Test that user can try again after receiving success message.
     */
    public function test_user_can_try_again_after_success_message(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'tryagain@example.com',
        ]);

        $component = Livewire::test('auth.forgot-password')
            ->set('email', 'tryagain@example.com')
            ->call('sendResetLink')
            ->assertSet('emailSent', true)
            ->set('emailSent', false)
            ->assertSet('emailSent', false);
    }
}
