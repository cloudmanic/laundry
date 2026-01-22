<?php

/**
 * File: DeviceTokenFactory.php
 * Description: Factory for generating test DeviceToken data
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace Database\Factories;

use App\Models\DeviceToken;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeviceToken>
 */
class DeviceTokenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DeviceToken::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'platform' => fake()->randomElement(DeviceToken::PLATFORMS),
            'token' => Str::random(64),
            'is_active' => true,
            'last_used_at' => fake()->optional(0.5)->dateTimeThisMonth(),
        ];
    }

    /**
     * Indicate that this is an iOS device.
     */
    public function ios(): static
    {
        return $this->state(fn (array $attributes) => [
            'platform' => 'ios',
        ]);
    }

    /**
     * Indicate that this is an Android device.
     */
    public function android(): static
    {
        return $this->state(fn (array $attributes) => [
            'platform' => 'android',
        ]);
    }

    /**
     * Indicate that this is a web push subscription.
     */
    public function web(): static
    {
        return $this->state(fn (array $attributes) => [
            'platform' => 'web',
        ]);
    }

    /**
     * Indicate that the token is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
