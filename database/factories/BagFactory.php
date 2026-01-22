<?php

/**
 * File: BagFactory.php
 * Description: Factory for generating test Bag data
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace Database\Factories;

use App\Models\Bag;
use App\Models\Pickup;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bag>
 */
class BagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'subscription_id' => Subscription::factory(),
            'pickup_id' => null,
            'qr_code' => 'LAU-'.strtoupper(Str::random(6)),
            'status' => 'with_customer',
            'label' => fake()->optional(0.5)->randomElement([
                'Master Bedroom',
                'Kids',
                'Guest Room',
                'Towels',
                'Whites',
                'Darks',
            ]),
            'scans' => null,
            'last_scanned_at' => null,
        ];
    }

    /**
     * Indicate that the bag is with the customer.
     */
    public function withCustomer(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'with_customer',
            'pickup_id' => null,
        ]);
    }

    /**
     * Indicate that the bag has been picked up.
     */
    public function pickedUp(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'picked_up',
            'last_scanned_at' => now(),
            'scans' => [
                [
                    'location' => 'pickup',
                    'scanned_by' => 'driver',
                    'scanned_at' => now()->toIso8601String(),
                ],
            ],
        ]);
    }

    /**
     * Indicate that the bag is at the facility.
     */
    public function atFacility(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'at_facility',
            'last_scanned_at' => now(),
            'scans' => [
                [
                    'location' => 'pickup',
                    'scanned_by' => 'driver',
                    'scanned_at' => now()->subHours(2)->toIso8601String(),
                ],
                [
                    'location' => 'facility_intake',
                    'scanned_by' => 'staff',
                    'scanned_at' => now()->toIso8601String(),
                ],
            ],
        ]);
    }

    /**
     * Indicate that the bag is being washed.
     */
    public function washing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'washing',
            'last_scanned_at' => now(),
        ]);
    }

    /**
     * Indicate that the bag is being dried.
     */
    public function drying(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'drying',
            'last_scanned_at' => now(),
        ]);
    }

    /**
     * Indicate that the bag is being folded.
     */
    public function folding(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'folding',
            'last_scanned_at' => now(),
        ]);
    }

    /**
     * Indicate that the bag is ready for delivery.
     */
    public function ready(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'ready',
            'last_scanned_at' => now(),
        ]);
    }

    /**
     * Indicate that the bag is out for delivery.
     */
    public function outForDelivery(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'out_for_delivery',
            'last_scanned_at' => now(),
        ]);
    }

    /**
     * Indicate that the bag has been delivered.
     */
    public function delivered(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'delivered',
            'last_scanned_at' => now(),
        ]);
    }

    /**
     * Set a specific label.
     */
    public function withLabel(string $label): static
    {
        return $this->state(fn (array $attributes) => [
            'label' => $label,
        ]);
    }

    /**
     * Associate with a specific pickup.
     *
     * @param  Pickup|int  $pickup
     */
    public function forPickup($pickup): static
    {
        $pickupId = $pickup instanceof Pickup ? $pickup->id : $pickup;

        return $this->state(fn (array $attributes) => [
            'pickup_id' => $pickupId,
        ]);
    }
}
