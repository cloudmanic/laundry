<?php

/**
 * File: SocialAccountFactory.php
 * Description: Factory for generating test SocialAccount data
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace Database\Factories;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SocialAccount>
 */
class SocialAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SocialAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'provider' => fake()->randomElement(SocialAccount::PROVIDERS),
            'provider_user_id' => Str::random(21),
            'provider_email' => fake()->safeEmail(),
            'token' => Str::random(64),
            'refresh_token' => Str::random(64),
            'token_expires_at' => now()->addDays(30),
        ];
    }

    /**
     * Indicate that this is a Google account.
     */
    public function google(): static
    {
        return $this->state(fn (array $attributes) => [
            'provider' => 'google',
        ]);
    }

    /**
     * Indicate that this is an Apple account.
     */
    public function apple(): static
    {
        return $this->state(fn (array $attributes) => [
            'provider' => 'apple',
        ]);
    }

    /**
     * Indicate that the token has expired.
     */
    public function expired(): static
    {
        return $this->state(fn (array $attributes) => [
            'token_expires_at' => now()->subDay(),
        ]);
    }
}
