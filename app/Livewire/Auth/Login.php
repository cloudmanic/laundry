<?php

/**
 * File: Login.php
 * Description: Livewire component for user login with real-time validation and verbose logging
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-22
 */

namespace App\Livewire\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.auth')]
#[Title('Sign In')]
class Login extends Component
{
    /**
     * The user's email address.
     */
    public string $email = '';

    /**
     * The user's password.
     */
    public string $password = '';

    /**
     * Whether the user wants to be remembered.
     */
    public bool $remember = false;

    /**
     * Whether the password should be shown.
     */
    public bool $showPassword = false;

    /**
     * Whether the form is currently being submitted.
     */
    public bool $isSubmitting = false;

    /**
     * The number of seconds until the user can try again after being rate limited.
     */
    public int $secondsUntilReset = 0;

    /**
     * Mount the component and log the page view.
     *
     * Initializes the component and logs that the login page was viewed.
     */
    public function mount(): void
    {
        // Log that the login page was viewed
        Log::info('Login page viewed', [
            'referrer' => request()->header('referer'),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'intended_url' => session()->get('url.intended'),
        ]);
    }

    /**
     * Get the validation rules for the login form.
     *
     * @return array<string, array<int, mixed>>
     */
    protected function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
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
            'password.required' => 'Please enter your password.',
        ];
    }

    /**
     * Real-time validation for email field.
     */
    public function updatedEmail(): void
    {
        $this->validateOnly('email');
    }

    /**
     * Toggle password visibility.
     */
    public function togglePasswordVisibility(): void
    {
        $this->showPassword = ! $this->showPassword;
    }

    /**
     * Get the rate limiting throttle key for this request.
     *
     * The key is a combination of the email and IP address to prevent
     * brute force attacks while allowing legitimate users from different
     * locations to attempt login.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
    }

    /**
     * Check if the user has been rate limited.
     */
    protected function isRateLimited(): bool
    {
        return RateLimiter::tooManyAttempts($this->throttleKey(), 5);
    }

    /**
     * Get the number of seconds until the rate limiter resets.
     */
    protected function getSecondsUntilReset(): int
    {
        return RateLimiter::availableIn($this->throttleKey());
    }

    /**
     * Handle the login form submission.
     *
     * Validates input, checks rate limiting, authenticates the user,
     * and redirects to the intended URL or onboarding.
     *
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function login()
    {
        // Prevent double submission
        if ($this->isSubmitting) {
            Log::debug('Login submission blocked - already submitting', [
                'email' => $this->email,
                'ip_address' => request()->ip(),
            ]);

            return null;
        }

        $this->isSubmitting = true;

        // Validate form fields
        $this->validate();

        // Check rate limiting before attempting authentication
        if ($this->isRateLimited()) {
            $this->secondsUntilReset = $this->getSecondsUntilReset();

            // Log the lockout event
            Log::warning('Login rate limited - too many attempts', [
                'email' => $this->email,
                'ip_address' => request()->ip(),
                'seconds_until_reset' => $this->secondsUntilReset,
                'user_agent' => request()->userAgent(),
            ]);

            // Fire the lockout event
            event(new Lockout(request()));

            $this->isSubmitting = false;

            throw ValidationException::withMessages([
                'email' => __('auth.throttle', [
                    'seconds' => $this->secondsUntilReset,
                    'minutes' => ceil($this->secondsUntilReset / 60),
                ]),
            ]);
        }

        // Attempt authentication
        $credentials = [
            'email' => Str::lower($this->email),
            'password' => $this->password,
        ];

        Log::info('Login attempt initiated', [
            'email' => $credentials['email'],
            'ip_address' => request()->ip(),
            'remember' => $this->remember,
            'user_agent' => request()->userAgent(),
        ]);

        if (! Auth::attempt($credentials, $this->remember)) {
            // Increment the rate limiter on failed attempt
            RateLimiter::hit($this->throttleKey());

            $attemptsRemaining = RateLimiter::remaining($this->throttleKey(), 5);

            // Log failed login attempt (without password)
            Log::warning('Login failed - invalid credentials', [
                'email' => $credentials['email'],
                'ip_address' => request()->ip(),
                'attempts_remaining' => $attemptsRemaining,
                'user_agent' => request()->userAgent(),
            ]);

            $this->isSubmitting = false;

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Clear rate limiter on successful login
        RateLimiter::clear($this->throttleKey());

        // Regenerate session to prevent session fixation
        session()->regenerate();

        // Get the authenticated user
        $user = Auth::user();

        // Log successful login
        Log::info('Login successful', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip_address' => request()->ip(),
            'remember' => $this->remember,
            'email_verified' => $user->hasVerifiedEmail(),
            'onboarding_completed' => $user->hasCompletedOnboarding(),
            'user_agent' => request()->userAgent(),
        ]);

        // Determine where to redirect the user
        $intendedUrl = session()->pull('url.intended', config('fortify.home', '/onboarding'));

        Log::debug('Redirecting user after login', [
            'user_id' => $user->id,
            'redirect_url' => $intendedUrl,
        ]);

        return redirect()->intended($intendedUrl);
    }

    /**
     * Render the login component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.auth.login');
    }
}
