<?php

/**
 * File: CreateNewUser.php
 * Description: Fortify action to create a new user during registration
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * This method handles the core user creation logic for the registration flow.
     * It validates all input fields, creates the user record, and logs the result.
     *
     * @param  array<string, string>  $input  The validated registration form data
     * @return User The newly created user instance
     *
     * @throws ValidationException When validation fails
     */
    public function create(array $input): User
    {
        // Log the registration attempt (without sensitive data)
        Log::info('Registration attempt initiated', [
            'email' => $input['email'] ?? 'not provided',
            'has_first_name' => isset($input['first_name']),
            'has_last_name' => isset($input['last_name']),
            'has_phone' => isset($input['phone']),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Validate the registration input
        $validator = Validator::make($input, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'phone' => ['required', 'string', 'max:20'],
            'password' => $this->passwordRules(),
            'terms' => ['required', 'accepted'],
        ], [
            'first_name.required' => 'Please enter your first name.',
            'last_name.required' => 'Please enter your last name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered. Try logging in instead.',
            'phone.required' => 'Please enter your phone number.',
            'password.required' => 'Please create a password.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
            'terms.required' => 'You must accept the terms of service.',
            'terms.accepted' => 'You must accept the terms of service.',
        ]);

        // If validation fails, log the errors and throw
        if ($validator->fails()) {
            Log::warning('Registration validation failed', [
                'email' => $input['email'] ?? 'not provided',
                'errors' => $validator->errors()->toArray(),
                'ip_address' => request()->ip(),
            ]);

            $validator->validate();
        }

        try {
            // Format the phone number (basic cleanup)
            $phone = $this->formatPhoneNumber($input['phone']);

            // Get the active city/region key
            $regionKey = config('city.active', 'sherwood');

            // Create the user
            $user = User::create([
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'email' => strtolower($input['email']),
                'phone' => $phone,
                'password' => Hash::make($input['password']),
                'region_key' => $regionKey,
            ]);

            // Log successful registration
            Log::info('Registration successful', [
                'user_id' => $user->id,
                'email' => $user->email,
                'region_key' => $user->region_key,
                'ip_address' => request()->ip(),
            ]);

            return $user;
        } catch (\Exception $e) {
            // Log the failure
            Log::error('Registration failed', [
                'email' => $input['email'] ?? 'not provided',
                'error' => $e->getMessage(),
                'ip_address' => request()->ip(),
            ]);

            throw $e;
        }
    }

    /**
     * Format a phone number for storage.
     *
     * Removes non-numeric characters and formats as a standard US phone number.
     *
     * @param  string  $phone  The raw phone number input
     * @return string The formatted phone number
     */
    private function formatPhoneNumber(string $phone): string
    {
        // Remove all non-numeric characters
        $digits = preg_replace('/[^0-9]/', '', $phone);

        // If the number starts with 1 (country code), remove it
        if (strlen($digits) === 11 && $digits[0] === '1') {
            $digits = substr($digits, 1);
        }

        // Format as (XXX) XXX-XXXX if we have 10 digits
        if (strlen($digits) === 10) {
            return sprintf(
                '(%s) %s-%s',
                substr($digits, 0, 3),
                substr($digits, 3, 3),
                substr($digits, 6, 4)
            );
        }

        // Return the cleaned number if it doesn't match expected format
        return $digits ?: $phone;
    }
}
