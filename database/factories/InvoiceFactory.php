<?php

/**
 * File: InvoiceFactory.php
 * Description: Factory for generating test Invoice data
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotalCents = fake()->randomElement([2900, 4900, 6900]); // Light, Family, Grand plans
        $discountCents = fake()->optional(0.2)->numberBetween(0, 1000) ?? 0;
        $taxCents = 0;
        $totalCents = $subtotalCents - $discountCents + $taxCents;

        return [
            'uuid' => (string) Str::uuid(),
            'user_id' => User::factory(),
            'subscription_id' => Subscription::factory(),
            'stripe_invoice_id' => 'in_'.Str::random(14),
            'invoice_number' => 'INV-'.now()->format('Ym').'-'.str_pad(fake()->unique()->numberBetween(1, 99999), 5, '0', STR_PAD_LEFT),
            'status' => 'paid',
            'subtotal_cents' => $subtotalCents,
            'discount_cents' => $discountCents,
            'tax_cents' => $taxCents,
            'total_cents' => $totalCents,
            'currency' => 'usd',
            'description' => 'Laundry service subscription',
            'period_start' => now()->startOfMonth(),
            'period_end' => now()->endOfMonth(),
            'due_date' => now()->startOfMonth()->addDays(7),
            'paid_at' => now(),
            'pdf_url' => null,
        ];
    }

    /**
     * Indicate that the invoice is paid.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    /**
     * Indicate that the invoice is open (unpaid).
     */
    public function open(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'open',
            'paid_at' => null,
            'due_date' => now()->addDays(7),
        ]);
    }

    /**
     * Indicate that the invoice is past due.
     */
    public function pastDue(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'open',
            'paid_at' => null,
            'due_date' => now()->subDays(3),
        ]);
    }

    /**
     * Indicate that the invoice is void.
     */
    public function void(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'void',
            'paid_at' => null,
        ]);
    }

    /**
     * Indicate that the invoice is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'paid_at' => null,
            'stripe_invoice_id' => null,
        ]);
    }

    /**
     * Indicate that the invoice is uncollectible.
     */
    public function uncollectible(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'uncollectible',
            'paid_at' => null,
        ]);
    }

    /**
     * Set a specific amount in dollars.
     */
    public function withAmount(float $amount): static
    {
        $cents = (int) ($amount * 100);

        return $this->state(fn (array $attributes) => [
            'subtotal_cents' => $cents,
            'total_cents' => $cents - $attributes['discount_cents'] + $attributes['tax_cents'],
        ]);
    }

    /**
     * Set a discount amount in dollars.
     */
    public function withDiscount(float $discount): static
    {
        $cents = (int) ($discount * 100);

        return $this->state(fn (array $attributes) => [
            'discount_cents' => $cents,
            'total_cents' => $attributes['subtotal_cents'] - $cents + $attributes['tax_cents'],
        ]);
    }

    /**
     * Indicate that there is no associated subscription.
     */
    public function withoutSubscription(): static
    {
        return $this->state(fn (array $attributes) => [
            'subscription_id' => null,
        ]);
    }
}
