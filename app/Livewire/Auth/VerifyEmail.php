<?php

/**
 * File: VerifyEmail.php
 * Description: Livewire component for email verification notice page with resend functionality
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-22
 */

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.auth')]
#[Title('Verify Your Email')]
class VerifyEmail extends Component
{
    /**
     * Whether the verification email was just resent.
     */
    public bool $emailResent = false;

    /**
     * Whether the form is currently being submitted.
     */
    public bool $isSubmitting = false;

    /**
     * The number of seconds until the user can try again after being rate limited.
     */
    public int $secondsUntilReset = 0;

    /**
     * Error message to display if rate limited.
     */
    public string $errorMessage = '';

    /**
     * Mount the component and log the page view.
     *
     * Initializes the component and logs that the verify email page was viewed.
     * Redirects to onboarding if user's email is already verified.
     */
    public function mount(): void
    {
        $user = Auth::user();

        // Log that the verification notice page was viewed
        Log::info('Email verification notice page viewed', [
            'user_id' => $user->id ?? null,
            'email' => $user->email ?? null,
            'email_verified' => $user->hasVerifiedEmail() ?? false,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // If user is already verified, redirect them
        if ($user && $user->hasVerifiedEmail()) {
            Log::info('Already verified user redirected from verification page', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);
        }
    }

    /**
     * Get the rate limiting throttle key for verification email resend requests.
     *
     * The key is based on the user ID to prevent abuse while allowing
     * legitimate resend requests from different devices.
     *
     * @return string The throttle key for rate limiting
     */
    protected function throttleKey(): string
    {
        return 'verification-resend:'.Auth::id();
    }

    /**
     * Check if the user has exceeded the verification email resend rate limit.
     *
     * Users are limited to 5 resend requests per hour per user.
     *
     * @return bool True if the user is rate limited
     */
    protected function isRateLimited(): bool
    {
        return RateLimiter::tooManyAttempts($this->throttleKey(), 5);
    }

    /**
     * Get the number of seconds until the rate limiter resets.
     *
     * @return int Seconds remaining until the user can try again
     */
    protected function getSecondsUntilReset(): int
    {
        return RateLimiter::availableIn($this->throttleKey());
    }

    /**
     * Resend the email verification notification.
     *
     * This method checks rate limiting and sends a new verification email
     * to the authenticated user.
     */
    public function resendVerificationEmail(): void
    {
        // Prevent double submission
        if ($this->isSubmitting) {
            Log::debug('Verification email resend blocked - already submitting', [
                'user_id' => Auth::id(),
                'ip_address' => request()->ip(),
            ]);

            return;
        }

        $this->isSubmitting = true;
        $this->errorMessage = '';

        $user = Auth::user();

        // Check if user is already verified
        if ($user->hasVerifiedEmail()) {
            Log::info('Verification email resend skipped - already verified', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);

            $this->isSubmitting = false;
            $this->redirect(route('onboarding'));

            return;
        }

        // Check rate limiting before sending
        if ($this->isRateLimited()) {
            $this->secondsUntilReset = $this->getSecondsUntilReset();

            Log::warning('Verification email resend rate limited', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip_address' => request()->ip(),
                'seconds_until_reset' => $this->secondsUntilReset,
                'user_agent' => request()->userAgent(),
            ]);

            $this->isSubmitting = false;
            $this->errorMessage = __('Too many verification email requests. Please try again in :minutes minutes.', [
                'minutes' => ceil($this->secondsUntilReset / 60),
            ]);

            return;
        }

        Log::info('Verification email resend requested', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Increment the rate limiter
        RateLimiter::hit($this->throttleKey(), 3600); // 1 hour decay

        // Send the verification email
        $user->sendEmailVerificationNotification();

        Log::info('Verification email resent successfully', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip_address' => request()->ip(),
        ]);

        $this->emailResent = true;
        $this->isSubmitting = false;
    }

    /**
     * Reset the email resent state to allow showing the form again.
     *
     * This allows users to request another resend after seeing the success message.
     */
    public function resetEmailResentState(): void
    {
        $this->emailResent = false;
    }

    /**
     * Render the verify email component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.auth.verify-email', [
            'user' => Auth::user(),
        ]);
    }
}
