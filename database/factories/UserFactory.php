<?php

/**
 * File: UserFactory.php
 * Description: Factory for generating test User data
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'phone' => fake()->phoneNumber(),
            'region_key' => 'sherwood',
            'stripe_customer_id' => null,
            'timezone' => 'America/Los_Angeles',
            'is_admin' => false,
            'onboarding_completed_at' => null,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user is an admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_admin' => true,
        ]);
    }

    /**
     * Indicate that the user has completed onboarding.
     */
    public function onboarded(): static
    {
        return $this->state(fn (array $attributes) => [
            'onboarding_completed_at' => now(),
        ]);
    }

    /**
     * Indicate that the user has a Stripe customer ID.
     */
    public function withStripe(): static
    {
        return $this->state(fn (array $attributes) => [
            'stripe_customer_id' => 'cus_'.Str::random(14),
        ]);
    }

    /**
     * Indicate that the user is in a specific region.
     */
    public function forRegion(string $region): static
    {
        return $this->state(fn (array $attributes) => [
            'region_key' => $region,
        ]);
    }
}
