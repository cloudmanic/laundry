<?php

/**
 * File: SubscriptionSeeder.php
 * Description: Seed the database with test subscriptions and related data
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace Database\Seeders;

use App\Models\Bag;
use App\Models\Invoice;
use App\Models\Pickup;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates subscriptions for the test users created in UserSeeder:
     * - Monday customer: Active Family plan
     * - Wednesday customer: Active Light plan
     * - Paused customer: Paused Grand plan
     */
    public function run(): void
    {
        // Get the test users created in UserSeeder
        $mondayCustomer = User::where('email', 'monday@example.com')->first();
        $wednesdayCustomer = User::where('email', 'wednesday@example.com')->first();
        $pausedCustomer = User::where('email', 'paused@example.com')->first();

        if ($mondayCustomer) {
            $this->createMondaySubscription($mondayCustomer);
        }

        if ($wednesdayCustomer) {
            $this->createWednesdaySubscription($wednesdayCustomer);
        }

        if ($pausedCustomer) {
            $this->createPausedSubscription($pausedCustomer);
        }
    }

    /**
     * Create an active Family plan subscription for the Monday customer.
     */
    private function createMondaySubscription(User $user): void
    {
        $address = $user->addresses()->first();

        // Create active subscription
        $subscription = Subscription::factory()
            ->forPlan('family')
            ->onPickupDay('monday')
            ->active()
            ->create([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'region_key' => 'sherwood',
            ]);

        // Create bags for the subscription
        Bag::factory()
            ->count(2)
            ->withCustomer()
            ->create([
                'subscription_id' => $subscription->id,
            ]);

        // Create some historical pickups
        Pickup::factory()
            ->delivered()
            ->create([
                'subscription_id' => $subscription->id,
                'address_id' => $address->id,
                'bags_expected' => 2,
                'bags_collected' => 2,
            ]);

        // Create an upcoming pickup
        $upcomingPickup = Pickup::factory()
            ->scheduled()
            ->create([
                'subscription_id' => $subscription->id,
                'address_id' => $address->id,
                'scheduled_date' => now()->next('monday'),
                'bags_expected' => 2,
            ]);

        // Create paid invoices
        Invoice::factory()
            ->paid()
            ->count(3)
            ->create([
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
            ]);
    }

    /**
     * Create an active Light plan subscription for the Wednesday customer.
     */
    private function createWednesdaySubscription(User $user): void
    {
        $address = $user->addresses()->first();

        // Create active subscription with trial
        $subscription = Subscription::factory()
            ->forPlan('light')
            ->onPickupDay('wednesday')
            ->active()
            ->onTrial(7)
            ->create([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'region_key' => 'sherwood',
                'promo_code' => 'WELCOME10',
            ]);

        // Create bag for the subscription
        Bag::factory()
            ->withCustomer()
            ->withLabel('All Laundry')
            ->create([
                'subscription_id' => $subscription->id,
            ]);

        // Create an upcoming pickup
        Pickup::factory()
            ->scheduled()
            ->create([
                'subscription_id' => $subscription->id,
                'address_id' => $address->id,
                'scheduled_date' => now()->next('wednesday'),
                'bags_expected' => 1,
            ]);

        // Create one invoice (still on trial, so might be $0 or partial)
        Invoice::factory()
            ->paid()
            ->withDiscount(2.90)
            ->create([
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
            ]);
    }

    /**
     * Create a paused Grand plan subscription for the paused customer.
     */
    private function createPausedSubscription(User $user): void
    {
        $address = $user->addresses()->first();

        // Create paused subscription
        $subscription = Subscription::factory()
            ->forPlan('grand')
            ->onPickupDay('friday')
            ->paused(2) // Paused for 2 weeks
            ->create([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'region_key' => 'sherwood',
            ]);

        // Create bags for the subscription
        Bag::factory()
            ->count(3)
            ->withCustomer()
            ->create([
                'subscription_id' => $subscription->id,
            ]);

        // Create historical pickups
        Pickup::factory()
            ->delivered()
            ->count(4)
            ->create([
                'subscription_id' => $subscription->id,
                'address_id' => $address->id,
                'bags_expected' => 3,
                'bags_collected' => 3,
            ]);

        // Create a skipped pickup (reason: customer on vacation)
        Pickup::factory()
            ->skipped('vacation')
            ->create([
                'subscription_id' => $subscription->id,
                'address_id' => $address->id,
                'bags_expected' => 3,
            ]);

        // Create paid invoices
        Invoice::factory()
            ->paid()
            ->count(5)
            ->create([
                'user_id' => $user->id,
                'subscription_id' => $subscription->id,
            ]);
    }
}
