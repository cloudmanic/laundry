<?php

/**
 * File: Register.php
 * Description: Livewire component for user registration with real-time validation
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace App\Livewire\Auth;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.auth')]
#[Title('Create Your Account')]
class Register extends Component
{
    /**
     * The user's first name.
     */
    public string $first_name = '';

    /**
     * The user's last name.
     */
    public string $last_name = '';

    /**
     * The user's email address.
     */
    public string $email = '';

    /**
     * The user's phone number.
     */
    public string $phone = '';

    /**
     * The user's password.
     */
    public string $password = '';

    /**
     * The password confirmation.
     */
    public string $password_confirmation = '';

    /**
     * Whether the user has accepted the terms of service.
     */
    public bool $terms = false;

    /**
     * Whether the password should be shown.
     */
    public bool $showPassword = false;

    /**
     * Whether the form is currently being submitted.
     */
    public bool $isSubmitting = false;

    /**
     * The selected plan key from the URL (if any).
     */
    public ?string $selectedPlan = null;

    /**
     * Mount the component and log the page view.
     *
     * Initializes the component and logs that the registration page was viewed.
     */
    public function mount(): void
    {
        // Get selected plan from query string
        $this->selectedPlan = request()->query('plan');

        // Log that the registration page was viewed
        Log::info('Registration page viewed', [
            'selected_plan' => $this->selectedPlan,
            'referrer' => request()->header('referer'),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Get the validation rules for the registration form.
     *
     * @return array<string, array<int, mixed>>
     */
    protected function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', Password::min(8), 'confirmed'],
            'password_confirmation' => ['required'],
            'terms' => ['required', 'accepted'],
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
            'first_name.required' => 'Please enter your first name.',
            'last_name.required' => 'Please enter your last name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered. Try logging in instead.',
            'phone.required' => 'Please enter your phone number.',
            'password.required' => 'Please create a password.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
            'password_confirmation.required' => 'Please confirm your password.',
            'terms.required' => 'You must accept the terms of service.',
            'terms.accepted' => 'You must accept the terms of service.',
        ];
    }

    /**
     * Real-time validation for first name field.
     */
    public function updatedFirstName(): void
    {
        $this->validateOnly('first_name');
    }

    /**
     * Real-time validation for last name field.
     */
    public function updatedLastName(): void
    {
        $this->validateOnly('last_name');
    }

    /**
     * Real-time validation for email field.
     */
    public function updatedEmail(): void
    {
        $this->validateOnly('email');
    }

    /**
     * Real-time validation for phone field.
     */
    public function updatedPhone(): void
    {
        $this->validateOnly('phone');
    }

    /**
     * Real-time validation for password field.
     */
    public function updatedPassword(): void
    {
        if (strlen($this->password) >= 1) {
            $this->validateOnly('password');
        }
    }

    /**
     * Real-time validation for password confirmation field.
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
     * Real-time validation for terms checkbox.
     */
    public function updatedTerms(): void
    {
        $this->validateOnly('terms');
    }

    /**
     * Toggle password visibility.
     */
    public function togglePasswordVisibility(): void
    {
        $this->showPassword = ! $this->showPassword;
    }

    /**
     * Calculate password strength for the UI indicator.
     *
     * Returns a score from 0-4 based on password complexity.
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
     * Handle the registration form submission.
     *
     * Validates input, creates the user, fires events, and redirects.
     *
     * @param  CreateNewUser  $creator  The Fortify user creation action
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function register(CreateNewUser $creator)
    {
        // Prevent double submission
        if ($this->isSubmitting) {
            return null;
        }

        $this->isSubmitting = true;

        // Validate all fields
        $this->validate();

        try {
            // Create the user using Fortify action
            $user = $creator->create([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'terms' => $this->terms,
            ]);

            // Fire the registered event (triggers email verification)
            event(new Registered($user));

            // Log the user in
            Auth::login($user);

            // Log successful registration
            Log::info('User registered and logged in via Livewire', [
                'user_id' => $user->id,
                'email' => $user->email,
                'selected_plan' => $this->selectedPlan,
            ]);

            // Redirect to onboarding with plan if selected
            $redirectUrl = config('fortify.home', '/onboarding');
            if ($this->selectedPlan) {
                $redirectUrl .= '?plan='.$this->selectedPlan;
            }

            return redirect()->intended($redirectUrl);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->isSubmitting = false;
            throw $e;
        } catch (\Exception $e) {
            $this->isSubmitting = false;

            Log::error('Registration failed in Livewire component', [
                'email' => $this->email,
                'error' => $e->getMessage(),
            ]);

            $this->addError('email', 'An error occurred during registration. Please try again.');

            return null;
        }
    }

    /**
     * Render the registration component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.auth.register');
    }
}
