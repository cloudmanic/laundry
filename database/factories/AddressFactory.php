<?php

/**
 * File: AddressFactory.php
 * Description: Factory for generating test Address data
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'user_id' => User::factory(),
            'label' => fake()->randomElement(Address::LABELS),
            'street_address' => fake()->streetAddress(),
            'unit' => fake()->optional(0.3)->buildingNumber(),
            'city' => 'Sherwood',
            'state' => 'OR',
            'zip_code' => '97140',
            'delivery_instructions' => fake()->optional(0.3)->sentence(),
            'latitude' => null,
            'longitude' => null,
            'formatted_address' => null,
            'place_id' => null,
            'geocoded_at' => null,
            'is_primary' => true,
            'is_validated' => false,
        ];
    }

    /**
     * Indicate that the address is primary.
     */
    public function primary(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_primary' => true,
        ]);
    }

    /**
     * Indicate that the address is secondary (not primary).
     */
    public function secondary(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_primary' => false,
        ]);
    }

    /**
     * Indicate that the address has been validated.
     */
    public function validated(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_validated' => true,
        ]);
    }

    /**
     * Indicate that the address has been geocoded.
     */
    public function geocoded(): static
    {
        return $this->state(fn (array $attributes) => [
            'latitude' => fake()->latitude(45.3, 45.4),
            'longitude' => fake()->longitude(-122.9, -122.8),
            'formatted_address' => "{$attributes['street_address']}, Sherwood, OR 97140, USA",
            'place_id' => 'ChIJ'.Str::random(23),
            'geocoded_at' => now(),
            'is_validated' => true,
        ]);
    }

    /**
     * Set a specific city and zip code.
     */
    public function inCity(string $city, string $state = 'OR', string $zipCode = '97140'): static
    {
        return $this->state(fn (array $attributes) => [
            'city' => $city,
            'state' => $state,
            'zip_code' => $zipCode,
        ]);
    }

    /**
     * Indicate that this is a home address.
     */
    public function home(): static
    {
        return $this->state(fn (array $attributes) => [
            'label' => 'Home',
        ]);
    }

    /**
     * Indicate that this is a work address.
     */
    public function work(): static
    {
        return $this->state(fn (array $attributes) => [
            'label' => 'Work',
        ]);
    }
}
