<?php

/**
 * File: CreateNewUserTest.php
 * Description: Unit tests for the CreateNewUser Fortify action
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace Tests\Unit\Actions\Fortify;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CreateNewUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a user can be created with valid data.
     */
    public function test_user_can_be_created_with_valid_data(): void
    {
        $creator = new CreateNewUser;

        $user = $creator->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '5035551234',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'terms' => true,
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John', $user->first_name);
        $this->assertEquals('Doe', $user->last_name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertTrue(Hash::check('Password123!', $user->password));
    }

    /**
     * Test phone number formatting with various formats.
     */
    public function test_phone_number_is_formatted(): void
    {
        $creator = new CreateNewUser;

        // Test with dashes
        $user1 = $creator->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john1@example.com',
            'phone' => '503-555-1234',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'terms' => true,
        ]);
        $this->assertEquals('(503) 555-1234', $user1->phone);

        // Test with country code
        $user2 = $creator->create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
            'phone' => '1-503-555-5678',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'terms' => true,
        ]);
        $this->assertEquals('(503) 555-5678', $user2->phone);

        // Test with parentheses
        $user3 = $creator->create([
            'first_name' => 'Bob',
            'last_name' => 'Smith',
            'email' => 'bob@example.com',
            'phone' => '(503) 555-9012',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'terms' => true,
        ]);
        $this->assertEquals('(503) 555-9012', $user3->phone);
    }

    /**
     * Test email is lowercased.
     */
    public function test_email_is_lowercased(): void
    {
        $creator = new CreateNewUser;

        $user = $creator->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'JOHN.DOE@EXAMPLE.COM',
            'phone' => '5035551234',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'terms' => true,
        ]);

        $this->assertEquals('john.doe@example.com', $user->email);
    }

    /**
     * Test that region key is set from config.
     */
    public function test_region_key_is_set_from_config(): void
    {
        config(['city.active' => 'sherwood']);

        $creator = new CreateNewUser;

        $user = $creator->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '5035551234',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'terms' => true,
        ]);

        $this->assertEquals('sherwood', $user->region_key);
    }

    /**
     * Test validation fails with missing first name.
     */
    public function test_validation_fails_with_missing_first_name(): void
    {
        $this->expectException(ValidationException::class);

        $creator = new CreateNewUser;

        $creator->create([
            'first_name' => '',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '5035551234',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'terms' => true,
        ]);
    }

    /**
     * Test validation fails with missing last name.
     */
    public function test_validation_fails_with_missing_last_name(): void
    {
        $this->expectException(ValidationException::class);

        $creator = new CreateNewUser;

        $creator->create([
            'first_name' => 'John',
            'last_name' => '',
            'email' => 'john@example.com',
            'phone' => '5035551234',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'terms' => true,
        ]);
    }

    /**
     * Test validation fails with invalid email.
     */
    public function test_validation_fails_with_invalid_email(): void
    {
        $this->expectException(ValidationException::class);

        $creator = new CreateNewUser;

        $creator->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'not-valid-email',
            'phone' => '5035551234',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'terms' => true,
        ]);
    }

    /**
     * Test validation fails with duplicate email.
     */
    public function test_validation_fails_with_duplicate_email(): void
    {
        // Create existing user
        User::factory()->create(['email' => 'existing@example.com']);

        $this->expectException(ValidationException::class);

        $creator = new CreateNewUser;

        $creator->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'existing@example.com',
            'phone' => '5035551234',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'terms' => true,
        ]);
    }

    /**
     * Test validation fails with short password.
     */
    public function test_validation_fails_with_short_password(): void
    {
        $this->expectException(ValidationException::class);

        $creator = new CreateNewUser;

        $creator->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '5035551234',
            'password' => 'short',
            'password_confirmation' => 'short',
            'terms' => true,
        ]);
    }

    /**
     * Test validation fails with unconfirmed password.
     */
    public function test_validation_fails_with_unconfirmed_password(): void
    {
        $this->expectException(ValidationException::class);

        $creator = new CreateNewUser;

        $creator->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '5035551234',
            'password' => 'Password123!',
            'password_confirmation' => 'DifferentPassword!',
            'terms' => true,
        ]);
    }

    /**
     * Test validation fails without terms acceptance.
     */
    public function test_validation_fails_without_terms_acceptance(): void
    {
        $this->expectException(ValidationException::class);

        $creator = new CreateNewUser;

        $creator->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '5035551234',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'terms' => false,
        ]);
    }

    /**
     * Test successful registration is logged.
     */
    public function test_successful_registration_is_logged(): void
    {
        Log::shouldReceive('info')
            ->once()
            ->withArgs(function ($message, $context) {
                return $message === 'Registration attempt initiated'
                    && $context['email'] === 'john@example.com';
            });

        Log::shouldReceive('info')
            ->once()
            ->withArgs(function ($message, $context) {
                return $message === 'Registration successful'
                    && $context['email'] === 'john@example.com';
            });

        $creator = new CreateNewUser;

        $creator->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '5035551234',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'terms' => true,
        ]);
    }

    /**
     * Test validation failure is logged.
     */
    public function test_validation_failure_is_logged(): void
    {
        Log::shouldReceive('info')
            ->once()
            ->withArgs(function ($message) {
                return $message === 'Registration attempt initiated';
            });

        Log::shouldReceive('warning')
            ->once()
            ->withArgs(function ($message, $context) {
                return $message === 'Registration validation failed'
                    && isset($context['errors']['email']);
            });

        $creator = new CreateNewUser;

        try {
            $creator->create([
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'invalid-email',
                'phone' => '5035551234',
                'password' => 'Password123!',
                'password_confirmation' => 'Password123!',
                'terms' => true,
            ]);
        } catch (ValidationException $e) {
            // Expected exception
        }
    }
}
