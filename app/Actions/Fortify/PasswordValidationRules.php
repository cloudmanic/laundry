<?php

/**
 * File: PasswordValidationRules.php
 * Description: Shared password validation rules for Fortify actions
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * Requires passwords to be at least 8 characters with confirmed match.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    protected function passwordRules(): array
    {
        return ['required', 'string', Password::min(8), 'confirmed'];
    }
}
