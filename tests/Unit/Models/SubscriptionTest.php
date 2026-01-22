<?php

/**
 * File: SubscriptionTest.php
 * Description: Unit tests for the Subscription model
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace Tests\Unit\Models;

use App\Models\Address;
use App\Models\Bag;
use App\Models\Invoice;
use App\Models\Pickup;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a UUID is auto-generated when creating a subscription.
     */
    public function test_uuid_is_auto_generated(): void
    {
        $subscription = Subscription::factory()->create(['uuid' => null]);

        $this->assertNotNull($subscription->uuid);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i',
            $subscription->uuid
        );
    }

    /**
     * Test the route key name is uuid.
     */
    public function test_route_key_name_is_uuid(): void
    {
        $subscription = new Subscription;

        $this->assertEquals('uuid', $subscription->getRouteKeyName());
    }

    /**
     * Test the user relationship.
     */
    public function test_user_relationship(): void
    {
        $user = User::factory()->create();
        $address = Address::factory()->create(['user_id' => $user->id]);
        $subscription = Subscription::factory()->create([
            'user_id' => $user->id,
            'address_id' => $address->id,
        ]);

        $this->assertNotNull($subscription->user);
        $this->assertEquals($user->id, $subscription->user->id);
    }

    /**
     * Test the address relationship.
     */
    public function test_address_relationship(): void
    {
        $user = User::factory()->create();
        $address = Address::factory()->create(['user_id' => $user->id]);
        $subscription = Subscription::factory()->create([
            'user_id' => $user->id,
            'address_id' => $address->id,
        ]);

        $this->assertNotNull($subscription->address);
        $this->assertEquals($address->id, $subscription->address->id);
    }

    /**
     * Test the pickups relationship.
     */
    public function test_pickups_relationship(): void
    {
        $subscription = Subscription::factory()->create();
        Pickup::factory()->count(3)->create([
            'subscription_id' => $subscription->id,
            'address_id' => $subscription->address_id,
        ]);

        $this->assertCount(3, $subscription->pickups);
    }

    /**
     * Test the bags relationship.
     */
    public function test_bags_relationship(): void
    {
        $subscription = Subscription::factory()->create();
        Bag::factory()->count(2)->create(['subscription_id' => $subscription->id]);

        $this->assertCount(2, $subscription->bags);
    }

    /**
     * Test the invoices relationship.
     */
    public function test_invoices_relationship(): void
    {
        $subscription = Subscription::factory()->create();
        Invoice::factory()->count(4)->create([
            'user_id' => $subscription->user_id,
            'subscription_id' => $subscription->id,
        ]);

        $this->assertCount(4, $subscription->invoices);
    }

    /**
     * Test getNextPickupDate returns next occurrence of pickup day.
     */
    public function test_get_next_pickup_date_returns_next_occurrence(): void
    {
        $subscription = Subscription::factory()->create(['pickup_day' => 'monday']);

        $nextPickup = $subscription->getNextPickupDate();

        $this->assertTrue($nextPickup->isMonday());
        $this->assertTrue($nextPickup->isFuture() || $nextPickup->isToday());
    }

    /**
     * Test isActive method.
     */
    public function test_is_active_method(): void
    {
        $activeSubscription = Subscription::factory()->active()->create();
        $pausedSubscription = Subscription::factory()->paused()->create();

        $this->assertTrue($activeSubscription->isActive());
        $this->assertFalse($pausedSubscription->isActive());
    }

    /**
     * Test isPaused method.
     */
    public function test_is_paused_method(): void
    {
        $activeSubscription = Subscription::factory()->active()->create();
        $pausedSubscription = Subscription::factory()->paused()->create();

        $this->assertFalse($activeSubscription->isPaused());
        $this->assertTrue($pausedSubscription->isPaused());
    }

    /**
     * Test isCancelled method.
     */
    public function test_is_cancelled_method(): void
    {
        $activeSubscription = Subscription::factory()->active()->create();
        $cancelledSubscription = Subscription::factory()->cancelled()->create();

        $this->assertFalse($activeSubscription->isCancelled());
        $this->assertTrue($cancelledSubscription->isCancelled());
    }

    /**
     * Test isPastDue method.
     */
    public function test_is_past_due_method(): void
    {
        $activeSubscription = Subscription::factory()->active()->create();
        $pastDueSubscription = Subscription::factory()->pastDue()->create();

        $this->assertFalse($activeSubscription->isPastDue());
        $this->assertTrue($pastDueSubscription->isPastDue());
    }

    /**
     * Test onTrial method.
     */
    public function test_on_trial_method(): void
    {
        $regularSubscription = Subscription::factory()->create(['trial_ends_at' => null]);
        $trialSubscription = Subscription::factory()->onTrial(14)->create();
        $expiredTrialSubscription = Subscription::factory()->create([
            'trial_ends_at' => now()->subDay(),
        ]);

        $this->assertFalse($regularSubscription->onTrial());
        $this->assertTrue($trialSubscription->onTrial());
        $this->assertFalse($expiredTrialSubscription->onTrial());
    }

    /**
     * Test willCancelAtPeriodEnd method.
     */
    public function test_will_cancel_at_period_end_method(): void
    {
        $regularSubscription = Subscription::factory()->create(['cancel_at_period_end' => false]);
        $cancellingSubscription = Subscription::factory()->cancellingAtPeriodEnd()->create();

        $this->assertFalse($regularSubscription->willCancelAtPeriodEnd());
        $this->assertTrue($cancellingSubscription->willCancelAtPeriodEnd());
    }

    /**
     * Test the status scope.
     */
    public function test_status_scope(): void
    {
        Subscription::factory()->active()->count(2)->create();
        Subscription::factory()->paused()->count(3)->create();

        $active = Subscription::status('active')->get();
        $paused = Subscription::status('paused')->get();

        $this->assertCount(2, $active);
        $this->assertCount(3, $paused);
    }

    /**
     * Test the active scope.
     */
    public function test_active_scope(): void
    {
        Subscription::factory()->active()->count(2)->create();
        Subscription::factory()->cancelled()->count(3)->create();

        $active = Subscription::active()->get();

        $this->assertCount(2, $active);
    }

    /**
     * Test the paused scope.
     */
    public function test_paused_scope(): void
    {
        Subscription::factory()->active()->count(2)->create();
        Subscription::factory()->paused()->count(3)->create();

        $paused = Subscription::paused()->get();

        $this->assertCount(3, $paused);
    }

    /**
     * Test the cancelled scope.
     */
    public function test_cancelled_scope(): void
    {
        Subscription::factory()->active()->count(2)->create();
        Subscription::factory()->cancelled()->count(3)->create();

        $cancelled = Subscription::cancelled()->get();

        $this->assertCount(3, $cancelled);
    }

    /**
     * Test the forRegion scope.
     */
    public function test_for_region_scope(): void
    {
        Subscription::factory()->count(2)->create(['region_key' => 'sherwood']);
        Subscription::factory()->count(3)->create(['region_key' => 'bend']);

        $sherwood = Subscription::forRegion('sherwood')->get();
        $bend = Subscription::forRegion('bend')->get();

        $this->assertCount(2, $sherwood);
        $this->assertCount(3, $bend);
    }

    /**
     * Test the forPickupDay scope.
     */
    public function test_for_pickup_day_scope(): void
    {
        Subscription::factory()->count(2)->create(['pickup_day' => 'monday']);
        Subscription::factory()->count(3)->create(['pickup_day' => 'wednesday']);

        $monday = Subscription::forPickupDay('monday')->get();
        $wednesday = Subscription::forPickupDay('wednesday')->get();

        $this->assertCount(2, $monday);
        $this->assertCount(3, $wednesday);
    }

    /**
     * Test the forPlan scope.
     */
    public function test_for_plan_scope(): void
    {
        Subscription::factory()->forPlan('light')->count(2)->create();
        Subscription::factory()->forPlan('family')->count(3)->create();

        $light = Subscription::forPlan('light')->get();
        $family = Subscription::forPlan('family')->get();

        $this->assertCount(2, $light);
        $this->assertCount(3, $family);
    }

    /**
     * Test the inDunning scope.
     */
    public function test_in_dunning_scope(): void
    {
        Subscription::factory()->active()->count(2)->create();
        Subscription::factory()->pastDue()->count(3)->create();

        $inDunning = Subscription::inDunning()->get();

        $this->assertCount(3, $inDunning);
    }

    /**
     * Test the scheduledToResume scope.
     */
    public function test_scheduled_to_resume_scope(): void
    {
        Subscription::factory()->active()->count(2)->create();
        Subscription::factory()->paused(2)->count(3)->create();

        $toResume = Subscription::scheduledToResume()->get();

        $this->assertCount(3, $toResume);
    }

    /**
     * Test soft deletes work correctly.
     */
    public function test_soft_deletes_work(): void
    {
        $subscription = Subscription::factory()->create();
        $subscriptionId = $subscription->id;

        $subscription->delete();

        $this->assertSoftDeleted('subscriptions', ['id' => $subscriptionId]);
        $this->assertNull(Subscription::find($subscriptionId));
        $this->assertNotNull(Subscription::withTrashed()->find($subscriptionId));
    }

    /**
     * Test PICKUP_DAYS constant contains valid days.
     */
    public function test_pickup_days_constant(): void
    {
        $expectedDays = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

        $this->assertEquals($expectedDays, Subscription::PICKUP_DAYS);
    }

    /**
     * Test STATUSES constant contains valid statuses.
     */
    public function test_statuses_constant(): void
    {
        $expectedStatuses = ['active', 'paused', 'cancelled', 'past_due'];

        $this->assertEquals($expectedStatuses, Subscription::STATUSES);
    }

    /**
     * Test PLAN_KEYS constant contains valid plans.
     */
    public function test_plan_keys_constant(): void
    {
        $expectedPlans = ['light', 'family', 'grand'];

        $this->assertEquals($expectedPlans, Subscription::PLAN_KEYS);
    }
}
