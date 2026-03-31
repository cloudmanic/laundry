<?php

/**
 * File: EmailVerificationTest.php
 * Description: Feature tests for email verification functionality
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-22
 */

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    /*
    |--------------------------------------------------------------------------
    | Verification Notice Page Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test that the verification notice page renders correctly for unverified users.
     */
    public function test_verification_notice_page_can_be_rendered(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get('/email/verify');

        $response->assertStatus(200);
        $response->assertSee('Check Your Email');
        $response->assertSee('Resend Verification Email');
    }

    /**
     * Test that the verification notice page contains branding elements.
     */
    public function test_verification_notice_page_contains_branding_elements(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get('/email/verify');

        $response->assertStatus(200);

        // Check for trust signals
        $response->assertSee('Secure verification');
        $response->assertSee('Privacy protected');

        // Check for what's next section
        $response->assertSee('What Happens Next');
        $response->assertSee('Check Your Inbox');
    }

    /**
     * Test that the verification notice page shows region branding from config.
     */
    public function test_verification_notice_page_shows_region_branding(): void
    {
        config(['city.active' => 'sherwood']);

        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get('/email/verify');

        $response->assertStatus(200);
        $response->assertSee('Sherwood');
    }

    /**
     * Test that the verification notice page shows user's email.
     */
    public function test_verification_notice_page_shows_user_email(): void
    {
        $user = User::factory()->unverified()->create([
            'email' => 'testuser@example.com',
        ]);

        $response = $this->actingAs($user)->get('/email/verify');

        $response->assertStatus(200);
        $response->assertSee('testuser@example.com');
    }

    /**
     * Test that unauthenticated users cannot access verification notice page.
     */
    public function test_unauthenticated_users_cannot_access_verification_notice(): void
    {
        $response = $this->get('/email/verify');

        $response->assertRedirect('/login');
    }

    /*
    |--------------------------------------------------------------------------
    | Verification Email Send on Registration Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test that verification email is sent on registration.
     */
    public function test_verification_email_sent_on_registration(): void
    {
        Notification::fake();

        Livewire::test('auth.register')
            ->set('first_name', 'Test')
            ->set('last_name', 'User')
            ->set('email', 'newuser@example.com')
            ->set('phone', '555-123-4567')
            ->set('password', 'Password123!')
            ->set('password_confirmation', 'Password123!')
            ->set('terms', true)
            ->call('register');

        $user = User::where('email', 'newuser@example.com')->first();
        $this->assertNotNull($user);

        Notification::assertSentTo($user, VerifyEmailNotification::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Resend Verification Email Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test that verification email can be resent.
     */
    public function test_verification_email_can_be_resent(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create([
            'email' => 'resend@example.com',
        ]);

        Livewire::actingAs($user)
            ->test('auth.verify-email')
            ->call('resendVerificationEmail')
            ->assertSet('emailResent', true)
            ->assertSet('errorMessage', '');

        Notification::assertSentTo($user, VerifyEmailNotification::class);
    }

    /**
     * Test that success message is shown after resending verification email.
     */
    public function test_success_message_shown_after_resending_verification(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create();

        $component = Livewire::actingAs($user)
            ->test('auth.verify-email')
            ->call('resendVerificationEmail');

        $this->assertTrue($component->get('emailResent'));
    }

    /**
     * Test that user can reset email resent state to resend again.
     */
    public function test_user_can_reset_email_resent_state(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create();

        $component = Livewire::actingAs($user)
            ->test('auth.verify-email')
            ->call('resendVerificationEmail')
            ->assertSet('emailResent', true)
            ->call('resetEmailResentState')
            ->assertSet('emailResent', false);
    }

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test that resend verification email is rate limited.
     */
    public function test_resend_verification_email_is_rate_limited(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create([
            'email' => 'ratelimit@example.com',
        ]);

        // Make 5 requests (the limit)
        for ($i = 0; $i < 5; $i++) {
            Livewire::actingAs($user)
                ->test('auth.verify-email')
                ->call('resendVerificationEmail')
                ->call('resetEmailResentState'); // Reset state to allow next request
        }

        // 6th request should be rate limited
        $component = Livewire::actingAs($user)
            ->test('auth.verify-email')
            ->call('resendVerificationEmail');

        $this->assertNotEmpty($component->get('errorMessage'));
        $this->assertStringContainsString('Too many', $component->get('errorMessage'));
    }

    /*
    |--------------------------------------------------------------------------
    | Email Verification Link Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test that email can be verified via link.
     */
    public function test_email_can_be_verified_via_link(): void
    {
        Event::fake([Verified::class]);

        $user = User::factory()->unverified()->create([
            'email' => 'verify@example.com',
        ]);

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertRedirect(route('onboarding'));

        // Verify user is now verified
        $user->refresh();
        $this->assertTrue($user->hasVerifiedEmail());

        // Verify Verified event was fired
        Event::assertDispatched(Verified::class);
    }

    /**
     * Test that verification fails with invalid hash.
     */
    public function test_verification_fails_with_invalid_hash(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => 'invalid-hash']
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertForbidden();

        // Verify user is still unverified
        $user->refresh();
        $this->assertFalse($user->hasVerifiedEmail());
    }

    /**
     * Test that verification fails with expired link.
     */
    public function test_verification_fails_with_expired_link(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->subMinutes(1), // Already expired
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertForbidden();

        // Verify user is still unverified
        $user->refresh();
        $this->assertFalse($user->hasVerifiedEmail());
    }

    /**
     * Test that verification fails for wrong user.
     */
    public function test_verification_fails_for_wrong_user(): void
    {
        $user1 = User::factory()->unverified()->create();
        $user2 = User::factory()->unverified()->create();

        // Create verification URL for user1
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user1->id, 'hash' => sha1($user1->email)]
        );

        // Try to use it as user2
        $response = $this->actingAs($user2)->get($verificationUrl);

        $response->assertForbidden();

        // Both users should still be unverified
        $user1->refresh();
        $user2->refresh();
        $this->assertFalse($user1->hasVerifiedEmail());
        $this->assertFalse($user2->hasVerifiedEmail());
    }

    /**
     * Test that verification requires authentication.
     */
    public function test_verification_requires_authentication(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->get($verificationUrl);

        $response->assertRedirect('/login');

        // Verify user is still unverified
        $user->refresh();
        $this->assertFalse($user->hasVerifiedEmail());
    }

    /*
    |--------------------------------------------------------------------------
    | Access Control Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test that unverified users are redirected to verification notice from protected routes.
     */
    public function test_unverified_users_redirected_from_protected_routes(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get('/onboarding');

        $response->assertRedirect('/email/verify');
    }

    /**
     * Test that verified users can access protected routes.
     */
    public function test_verified_users_can_access_protected_routes(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/onboarding');

        $response->assertStatus(200);
    }

    /**
     * Test that verified user is not blocked by resend for already verified.
     */
    public function test_resend_redirects_if_already_verified(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        Livewire::actingAs($user)
            ->test('auth.verify-email')
            ->call('resendVerificationEmail')
            ->assertRedirect(route('onboarding'));

        // No notification should be sent since user is already verified
        Notification::assertNothingSent();
    }

    /*
    |--------------------------------------------------------------------------
    | Route Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test verification notice route exists and has correct name.
     */
    public function test_verification_notice_route_exists(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get(route('verification.notice'));

        $response->assertStatus(200);
    }

    /**
     * Test verification verify route exists and has correct name.
     */
    public function test_verification_verify_route_exists(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertRedirect(route('onboarding'));
    }

    /*
    |--------------------------------------------------------------------------
    | Loading State Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test loading state during resend verification submission.
     */
    public function test_loading_state_during_resend_submission(): void
    {
        $user = User::factory()->unverified()->create();

        $component = Livewire::actingAs($user)
            ->test('auth.verify-email');

        $this->assertFalse($component->get('isSubmitting'));
    }

    /*
    |--------------------------------------------------------------------------
    | Custom Notification Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test that custom verification notification is used.
     */
    public function test_custom_verification_notification_is_used(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create();

        $user->sendEmailVerificationNotification();

        Notification::assertSentTo(
            $user,
            VerifyEmailNotification::class,
            function ($notification) {
                return true;
            }
        );
    }

    /**
     * Test that verification notification contains correct data.
     */
    public function test_verification_notification_contains_correct_data(): void
    {
        $user = User::factory()->unverified()->create([
            'email' => 'notification@example.com',
        ]);

        $notification = new VerifyEmailNotification;
        $mailMessage = $notification->toMail($user);

        // Verify the notification uses the correct view
        $this->assertEquals('emails.verify-email', $mailMessage->view);
    }

    /*
    |--------------------------------------------------------------------------
    | Logout From Verification Page Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test that logout link is present on verification notice page.
     */
    public function test_logout_link_present_on_verification_page(): void
    {
        $user = User::factory()->unverified()->create();

        $response = $this->actingAs($user)->get('/email/verify');

        $response->assertStatus(200);
        $response->assertSee('Sign out and use a different email');
    }

    /*
    |--------------------------------------------------------------------------
    | Double Submission Prevention Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test that double submission is prevented.
     */
    public function test_double_submission_is_prevented(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create();

        $component = Livewire::actingAs($user)
            ->test('auth.verify-email');

        // Manually set isSubmitting to true to simulate double submission
        $component->set('isSubmitting', true)
            ->call('resendVerificationEmail');

        // When isSubmitting is already true, no notification should be sent
        // The method returns early
        Notification::assertNothingSent();
    }

    /*
    |--------------------------------------------------------------------------
    | Session Tests
    |--------------------------------------------------------------------------
    */

    /**
     * Test that verification success session message is passed.
     */
    public function test_verification_success_session_message_passed(): void
    {
        $user = User::factory()->unverified()->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        $response->assertRedirect(route('onboarding'));
        $response->assertSessionHas('verified', true);
    }
}
