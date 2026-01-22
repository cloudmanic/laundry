<?php

/**
 * File: ForgotPassword.php
 * Description: Livewire component for requesting password reset emails with rate limiting
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-22
 */

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.auth')]
#[Title('Forgot Password')]
class ForgotPassword extends Component
{
    /**
     * The user's email address for password reset.
     */
    public string $email = '';

    /**
     * Whether the form is currently being submitted.
     */
    public bool $isSubmitting = false;

    /**
     * Whether the reset email was successfully sent.
     */
    public bool $emailSent = false;

    /**
     * The number of seconds until the user can try again after being rate limited.
     */
    public int $secondsUntilReset = 0;

    /**
     * Mount the component and log the page view.
     *
     * Initializes the component and logs that the forgot password page was viewed.
     */
    public function mount(): void
    {
        // Log that the forgot password page was viewed
        Log::info('Forgot password page viewed', [
            'referrer' => request()->header('referer'),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Get the validation rules for the forgot password form.
     *
     * @return array<string, array<int, mixed>>
     */
    protected function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
        ];
    }

    /**
     * Real-time validation for email field.
     *
     * Validates the email field when it loses focus.
     */
    public function updatedEmail(): void
    {
        $this->validateOnly('email');
    }

    /**
     * Get the rate limiting throttle key for password reset requests.
     *
     * The key is based on the email address to prevent abuse while allowing
     * legitimate users to request resets from different devices.
     *
     * @return string The throttle key for rate limiting
     */
    protected function throttleKey(): string
    {
        return 'password-reset:'.Str::transliterate(Str::lower($this->email));
    }

    /**
     * Check if the user has exceeded the password reset rate limit.
     *
     * Users are limited to 3 password reset requests per hour per email.
     *
     * @return bool True if the user is rate limited
     */
    protected function isRateLimited(): bool
    {
        return RateLimiter::tooManyAttempts($this->throttleKey(), 3);
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
     * Send the password reset link to the user's email.
     *
     * This method validates the email, checks rate limiting, and sends
     * the password reset email using Laravel's Password facade.
     */
    public function sendResetLink(): void
    {
        // Prevent double submission
        if ($this->isSubmitting) {
            Log::debug('Password reset submission blocked - already submitting', [
                'email' => $this->email,
                'ip_address' => request()->ip(),
            ]);

            return;
        }

        $this->isSubmitting = true;

        // Validate email format
        $this->validate();

        // Normalize the email to lowercase
        $email = Str::lower($this->email);

        // Check rate limiting before sending reset email
        if ($this->isRateLimited()) {
            $this->secondsUntilReset = $this->getSecondsUntilReset();

            Log::warning('Password reset rate limited', [
                'email' => $email,
                'ip_address' => request()->ip(),
                'seconds_until_reset' => $this->secondsUntilReset,
                'user_agent' => request()->userAgent(),
            ]);

            $this->isSubmitting = false;

            $this->addError('email', __('Too many password reset attempts. Please try again in :minutes minutes.', [
                'minutes' => ceil($this->secondsUntilReset / 60),
            ]));

            return;
        }

        Log::info('Password reset requested', [
            'email' => $email,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Increment the rate limiter
        RateLimiter::hit($this->throttleKey(), 3600); // 1 hour decay

        // Send the password reset link
        $status = Password::sendResetLink(['email' => $email]);

        // Log the result
        if ($status === Password::RESET_LINK_SENT) {
            Log::info('Password reset link sent successfully', [
                'email' => $email,
                'ip_address' => request()->ip(),
            ]);

            $this->emailSent = true;
            $this->isSubmitting = false;

            return;
        }

        // Handle various failure scenarios
        if ($status === Password::INVALID_USER) {
            // For security, we show the same success message even if user doesn't exist
            // This prevents email enumeration attacks
            Log::info('Password reset requested for non-existent user', [
                'email' => $email,
                'ip_address' => request()->ip(),
            ]);

            $this->emailSent = true;
            $this->isSubmitting = false;

            return;
        }

        if ($status === Password::RESET_THROTTLED) {
            Log::warning('Password reset throttled by Laravel', [
                'email' => $email,
                'ip_address' => request()->ip(),
            ]);

            $this->isSubmitting = false;

            $this->addError('email', __('Please wait before requesting another reset link.'));

            return;
        }

        // Generic error for any other failure
        Log::error('Password reset failed with unknown status', [
            'email' => $email,
            'status' => $status,
            'ip_address' => request()->ip(),
        ]);

        $this->isSubmitting = false;

        $this->addError('email', __('Unable to send password reset link. Please try again later.'));
    }

    /**
     * Render the forgot password component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
