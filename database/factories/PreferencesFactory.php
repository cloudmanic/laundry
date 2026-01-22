<?php

/**
 * File: PreferencesFactory.php
 * Description: Factory for generating test Preferences data
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace Database\Factories;

use App\Models\Preferences;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Preferences>
 */
class PreferencesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Preferences::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'detergent' => fake()->randomElement(Preferences::DETERGENT_OPTIONS),
        ];
    }

    /**
     * Indicate that regular detergent is preferred.
     */
    public function regular(): static
    {
        return $this->state(fn (array $attributes) => [
            'detergent' => 'regular',
        ]);
    }

    /**
     * Indicate that fragrance-free detergent is preferred.
     */
    public function fragranceFree(): static
    {
        return $this->state(fn (array $attributes) => [
            'detergent' => 'fragrance_free',
        ]);
    }

    /**
     * Indicate that hypoallergenic detergent is preferred.
     */
    public function hypoallergenic(): static
    {
        return $this->state(fn (array $attributes) => [
            'detergent' => 'hypoallergenic',
        ]);
    }

    /**
     * Indicate that eco-friendly detergent is preferred.
     */
    public function ecoFriendly(): static
    {
        return $this->state(fn (array $attributes) => [
            'detergent' => 'eco_friendly',
        ]);
    }
}
