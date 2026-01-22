<?php

/**
 * File: SubscriptionFactory.php
 * Description: Factory for generating test Subscription data
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace Database\Factories;

use App\Models\Address;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $planKey = fake()->randomElement(Subscription::PLAN_KEYS);
        $bagsPerWeek = match ($planKey) {
            'light' => 1,
            'family' => 2,
            'grand' => 3,
            default => 1,
        };

        return [
            'uuid' => (string) Str::uuid(),
            'user_id' => User::factory(),
            'address_id' => Address::factory(),
            'region_key' => 'sherwood',
            'plan_key' => $planKey,
            'status' => 'active',
            'bags_per_week' => $bagsPerWeek,
            'pickup_day' => fake()->randomElement(Subscription::PICKUP_DAYS),
            'stripe_subscription_id' => null,
            'stripe_price_id' => null,
            'stripe_status' => null,
            'current_period_start' => now()->startOfMonth(),
            'current_period_end' => now()->endOfMonth(),
            'trial_ends_at' => null,
            'paused_at' => null,
            'resume_at' => null,
            'pause_weeks' => null,
            'cancelled_at' => null,
            'cancellation_reason' => null,
            'cancellation_feedback' => null,
            'cancel_at_period_end' => false,
            'dunning_started_at' => null,
            'dunning_emails_sent' => 0,
            'promo_code' => null,
            'skips_used_this_period' => 0,
        ];
    }

    /**
     * Indicate that the subscription is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'paused_at' => null,
            'cancelled_at' => null,
        ]);
    }

    /**
     * Indicate that the subscription is paused.
     *
     * @param  int  $weeks  Number of weeks to pause
     */
    public function paused(int $weeks = 2): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paused',
            'paused_at' => now(),
            'resume_at' => now()->addWeeks($weeks),
            'pause_weeks' => $weeks,
        ]);
    }

    /**
     * Indicate that the subscription is cancelled.
     */
    public function cancelled(?string $reason = null): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $reason ?? fake()->randomElement([
                'too_expensive',
                'not_using_enough',
                'moving',
                'other',
            ]),
            'cancellation_feedback' => fake()->optional()->sentence(),
        ]);
    }

    /**
     * Indicate that the subscription is past due.
     */
    public function pastDue(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'past_due',
            'dunning_started_at' => now()->subDays(3),
            'dunning_emails_sent' => 1,
        ]);
    }

    /**
     * Indicate that the subscription has Stripe data.
     */
    public function withStripe(): static
    {
        return $this->state(fn (array $attributes) => [
            'stripe_subscription_id' => 'sub_'.Str::random(14),
            'stripe_price_id' => 'price_'.Str::random(14),
            'stripe_status' => 'active',
        ]);
    }

    /**
     * Indicate that the subscription is on a trial.
     */
    public function onTrial(int $days = 14): static
    {
        return $this->state(fn (array $attributes) => [
            'trial_ends_at' => now()->addDays($days),
        ]);
    }

    /**
     * Set a specific plan.
     */
    public function forPlan(string $planKey): static
    {
        $bagsPerWeek = match ($planKey) {
            'light' => 1,
            'family' => 2,
            'grand' => 3,
            default => 1,
        };

        return $this->state(fn (array $attributes) => [
            'plan_key' => $planKey,
            'bags_per_week' => $bagsPerWeek,
        ]);
    }

    /**
     * Set a specific pickup day.
     */
    public function onPickupDay(string $day): static
    {
        return $this->state(fn (array $attributes) => [
            'pickup_day' => $day,
        ]);
    }

    /**
     * Indicate that the subscription will cancel at period end.
     */
    public function cancellingAtPeriodEnd(): static
    {
        return $this->state(fn (array $attributes) => [
            'cancel_at_period_end' => true,
        ]);
    }

    /**
     * Set a promo code.
     */
    public function withPromoCode(string $code): static
    {
        return $this->state(fn (array $attributes) => [
            'promo_code' => $code,
        ]);
    }
}
