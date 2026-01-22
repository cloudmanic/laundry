<?php

/**
 * File: PickupFactory.php
 * Description: Factory for generating test Pickup data
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace Database\Factories;

use App\Models\Address;
use App\Models\Pickup;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pickup>
 */
class PickupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pickup::class;

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
            'address_id' => Address::factory(),
            'scheduled_date' => now()->addDays(fake()->numberBetween(1, 7)),
            'status' => 'scheduled',
            'bags_expected' => fake()->numberBetween(1, 3),
            'bags_collected' => null,
            'reminder_sent_at' => null,
            'picked_up_at' => null,
            'processing_started_at' => null,
            'ready_at' => null,
            'out_for_delivery_at' => null,
            'delivered_at' => null,
            'skipped_at' => null,
            'skip_reason' => null,
            'driver_notes' => null,
            'delivery_photo_path' => null,
        ];
    }

    /**
     * Indicate that the pickup is scheduled.
     */
    public function scheduled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'scheduled',
        ]);
    }

    /**
     * Indicate that a reminder has been sent.
     */
    public function reminderSent(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'reminder_sent',
            'reminder_sent_at' => now()->subHours(12),
        ]);
    }

    /**
     * Indicate that the pickup has been picked up.
     */
    public function pickedUp(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'picked_up',
                'reminder_sent_at' => now()->subDay(),
                'picked_up_at' => now(),
                'bags_collected' => $attributes['bags_expected'],
            ];
        });
    }

    /**
     * Indicate that the pickup is being processed.
     */
    public function processing(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'processing',
                'reminder_sent_at' => now()->subDays(2),
                'picked_up_at' => now()->subDay(),
                'processing_started_at' => now()->subHours(6),
                'bags_collected' => $attributes['bags_expected'],
            ];
        });
    }

    /**
     * Indicate that the pickup is ready for delivery.
     */
    public function ready(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'ready',
                'reminder_sent_at' => now()->subDays(3),
                'picked_up_at' => now()->subDays(2),
                'processing_started_at' => now()->subDays(2)->addHours(2),
                'ready_at' => now()->subDay(),
                'bags_collected' => $attributes['bags_expected'],
            ];
        });
    }

    /**
     * Indicate that the pickup is out for delivery.
     */
    public function outForDelivery(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'out_for_delivery',
                'reminder_sent_at' => now()->subDays(3),
                'picked_up_at' => now()->subDays(2),
                'processing_started_at' => now()->subDays(2)->addHours(2),
                'ready_at' => now()->subDay(),
                'out_for_delivery_at' => now()->subHours(2),
                'bags_collected' => $attributes['bags_expected'],
            ];
        });
    }

    /**
     * Indicate that the pickup has been delivered.
     */
    public function delivered(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'delivered',
                'scheduled_date' => now()->subDays(3),
                'reminder_sent_at' => now()->subDays(4),
                'picked_up_at' => now()->subDays(3),
                'processing_started_at' => now()->subDays(2),
                'ready_at' => now()->subDay(),
                'out_for_delivery_at' => now()->subHours(4),
                'delivered_at' => now(),
                'bags_collected' => $attributes['bags_expected'],
            ];
        });
    }

    /**
     * Indicate that the pickup was skipped.
     */
    public function skipped(?string $reason = null): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'skipped',
            'skipped_at' => now(),
            'skip_reason' => $reason ?? fake()->randomElement([
                'customer_request',
                'vacation',
                'other',
            ]),
        ]);
    }

    /**
     * Indicate that the pickup was missed.
     */
    public function missed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'missed',
            'scheduled_date' => now()->subDay(),
        ]);
    }

    /**
     * Set a specific scheduled date.
     *
     * @param  \DateTimeInterface|string  $date
     */
    public function forDate($date): static
    {
        return $this->state(fn (array $attributes) => [
            'scheduled_date' => $date,
        ]);
    }

    /**
     * Schedule the pickup for today.
     */
    public function today(): static
    {
        return $this->state(fn (array $attributes) => [
            'scheduled_date' => today(),
        ]);
    }

    /**
     * Add driver notes.
     */
    public function withDriverNotes(?string $notes = null): static
    {
        return $this->state(fn (array $attributes) => [
            'driver_notes' => $notes ?? fake()->sentence(),
        ]);
    }
}
