<?php

/**
 * File: ResetPassword.php
 * Description: Livewire component for resetting password with token validation
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-22
 */

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.auth')]
#[Title('Reset Password')]
class ResetPassword extends Component
{
    /**
     * The password reset token from the URL.
     */
    public string $token = '';

    /**
     * The user's email address from the URL or form.
     */
    public string $email = '';

    /**
     * The user's new password.
     */
    public string $password = '';

    /**
     * The password confirmation.
     */
    public string $password_confirmation = '';

    /**
     * Whether the password should be shown.
     */
    public bool $showPassword = false;

    /**
     * Whether the form is currently being submitted.
     */
    public bool $isSubmitting = false;

    /**
     * Whether the password was successfully reset.
     */
    public bool $resetComplete = false;

    /**
     * Mount the component with the token and email from the URL.
     *
     * Initializes the component with data from the password reset link
     * and logs the reset page view.
     *
     * @param  string  $token  The password reset token from the URL
     */
    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = request()->query('email', '');

        // Log that the reset password page was viewed
        Log::info('Reset password page viewed', [
            'email' => $this->email,
            'has_token' => ! empty($this->token),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Get the validation rules for the reset password form.
     *
     * @return array<string, array<int, mixed>>
     */
    protected function rules(): array
    {
        return [
            'token' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', PasswordRule::min(8), 'confirmed'],
            'password_confirmation' => ['required', 'string'],
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
            'password.required' => 'Please enter your new password.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
            'password_confirmation.required' => 'Please confirm your new password.',
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
     * Real-time validation for password field.
     *
     * Validates the password field as the user types (with debounce).
     */
    public function updatedPassword(): void
    {
        if (strlen($this->password) >= 1) {
            $this->validateOnly('password');
        }
    }

    /**
     * Real-time validation for password confirmation field.
     *
     * Validates the confirmation matches the password.
     */
    public function updatedPasswordConfirmation(): void
    {
        if (strlen($this->password_confirmation) >= 1) {
            $this->validateOnly('password_confirmation');
            // Also validate password to check if they match
            if (strlen($this->password) >= 8) {
                $this->validateOnly('password');
            }
        }
    }

    /**
     * Toggle password visibility.
     *
     * Switches between showing and hiding the password fields.
     */
    public function togglePasswordVisibility(): void
    {
        $this->showPassword = ! $this->showPassword;
    }

    /**
     * Calculate password strength for the UI indicator.
     *
     * Returns a score from 0-4 based on password complexity.
     * Evaluates length, mixed case, numbers, and special characters.
     *
     * @return int Password strength score (0-4)
     */
    public function getPasswordStrengthProperty(): int
    {
        $password = $this->password;
        $strength = 0;

        if (strlen($password) >= 8) {
            $strength++;
        }
        if (strlen($password) >= 12) {
            $strength++;
        }
        if (preg_match('/[A-Z]/', $password) && preg_match('/[a-z]/', $password)) {
            $strength++;
        }
        if (preg_match('/[0-9]/', $password)) {
            $strength++;
        }
        if (preg_match('/[^A-Za-z0-9]/', $password)) {
            $strength++;
        }

        return min($strength, 4);
    }

    /**
     * Get the password strength label for display.
     *
     * Returns a human-readable label based on the password strength score.
     *
     * @return string Password strength label (Weak, Fair, Good, Strong)
     */
    public function getPasswordStrengthLabelProperty(): string
    {
        return match ($this->passwordStrength) {
            0 => '',
            1 => 'Weak',
            2 => 'Fair',
            3 => 'Good',
            4 => 'Strong',
            default => '',
        };
    }

    /**
     * Get the password strength color class.
     *
     * Returns a Tailwind CSS class based on the password strength score.
     *
     * @return string Tailwind CSS background color class
     */
    public function getPasswordStrengthColorProperty(): string
    {
        return match ($this->passwordStrength) {
            1 => 'bg-red-500',
            2 => 'bg-yellow-500',
            3 => 'bg-emerald-400',
            4 => 'bg-emerald-600',
            default => 'bg-slate-200',
        };
    }

    /**
     * Reset the user's password.
     *
     * Validates the form, resets the password using Laravel's Password broker,
     * logs the user in, and redirects to the dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function resetPassword()
    {
        // Prevent double submission
        if ($this->isSubmitting) {
            Log::debug('Password reset submission blocked - already submitting', [
                'email' => $this->email,
                'ip_address' => request()->ip(),
            ]);

            return null;
        }

        $this->isSubmitting = true;

        // Validate all fields
        $this->validate();

        // Normalize the email to lowercase
        $email = Str::lower($this->email);

        Log::info('Password reset attempt initiated', [
            'email' => $email,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Attempt to reset the password
        $status = Password::reset(
            [
                'email' => $email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'token' => $this->token,
            ],
            function (User $user, string $password) {
                // Update the user's password
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                // Fire the PasswordReset event
                event(new PasswordReset($user));

                Log::info('Password reset successful', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'ip_address' => request()->ip(),
                ]);
            }
        );

        // Handle the result
        if ($status === Password::PASSWORD_RESET) {
            // Find the user and log them in
            $user = User::where('email', $email)->first();

            if ($user) {
                // Regenerate session to prevent session fixation
                session()->regenerate();

                // Log the user in
                Auth::login($user);

                Log::info('User logged in after password reset', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'ip_address' => request()->ip(),
                ]);

                $this->resetComplete = true;
                $this->isSubmitting = false;

                // Redirect to onboarding/dashboard
                return redirect()->intended(config('fortify.home', '/onboarding'));
            }
        }

        // Handle error scenarios
        $this->isSubmitting = false;

        if ($status === Password::INVALID_TOKEN) {
            Log::warning('Password reset failed - invalid or expired token', [
                'email' => $email,
                'ip_address' => request()->ip(),
            ]);

            $this->addError('email', __('This password reset link has expired or is invalid. Please request a new one.'));

            return null;
        }

        if ($status === Password::INVALID_USER) {
            Log::warning('Password reset failed - invalid user', [
                'email' => $email,
                'ip_address' => request()->ip(),
            ]);

            $this->addError('email', __('We could not find a user with that email address.'));

            return null;
        }

        // Generic error for any other failure
        Log::error('Password reset failed with unknown status', [
            'email' => $email,
            'status' => $status,
            'ip_address' => request()->ip(),
        ]);

        $this->addError('email', __('Unable to reset password. Please try again.'));

        return null;
    }

    /**
     * Render the reset password component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
