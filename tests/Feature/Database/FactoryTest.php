<?php

/**
 * File: FactoryTest.php
 * Description: Tests to verify all factories create valid models
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace Tests\Feature\Database;

use App\Models\Address;
use App\Models\Bag;
use App\Models\Invoice;
use App\Models\NotificationPreferences;
use App\Models\Pickup;
use App\Models\Preferences;
use App\Models\SocialAccount;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FactoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the User factory creates a valid user.
     */
    public function test_user_factory_creates_valid_user(): void
    {
        $user = User::factory()->create();

        $this->assertNotNull($user->id);
        $this->assertNotNull($user->uuid);
        $this->assertNotNull($user->first_name);
        $this->assertNotNull($user->last_name);
        $this->assertNotNull($user->email);
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    /**
     * Test that the User factory admin state works.
     */
    public function test_user_factory_admin_state_works(): void
    {
        $admin = User::factory()->admin()->create();

        $this->assertTrue($admin->is_admin);
    }

    /**
     * Test that the User factory onboarded state works.
     */
    public function test_user_factory_onboarded_state_works(): void
    {
        $user = User::factory()->onboarded()->create();

        $this->assertNotNull($user->onboarding_completed_at);
        $this->assertTrue($user->hasCompletedOnboarding());
    }

    /**
     * Test that the SocialAccount factory creates a valid social account.
     */
    public function test_social_account_factory_creates_valid_account(): void
    {
        $account = SocialAccount::factory()->create();

        $this->assertNotNull($account->id);
        $this->assertNotNull($account->user_id);
        $this->assertContains($account->provider, SocialAccount::PROVIDERS);
        $this->assertDatabaseHas('social_accounts', ['id' => $account->id]);
    }

    /**
     * Test that the SocialAccount factory google state works.
     */
    public function test_social_account_factory_google_state_works(): void
    {
        $account = SocialAccount::factory()->google()->create();

        $this->assertEquals('google', $account->provider);
    }

    /**
     * Test that the Address factory creates a valid address.
     */
    public function test_address_factory_creates_valid_address(): void
    {
        $address = Address::factory()->create();

        $this->assertNotNull($address->id);
        $this->assertNotNull($address->uuid);
        $this->assertNotNull($address->street_address);
        $this->assertNotNull($address->city);
        $this->assertNotNull($address->state);
        $this->assertNotNull($address->zip_code);
        $this->assertDatabaseHas('addresses', ['id' => $address->id]);
    }

    /**
     * Test that the Address factory geocoded state works.
     */
    public function test_address_factory_geocoded_state_works(): void
    {
        $address = Address::factory()->geocoded()->create();

        $this->assertNotNull($address->latitude);
        $this->assertNotNull($address->longitude);
        $this->assertTrue($address->isGeocoded());
    }

    /**
     * Test that the Subscription factory creates a valid subscription.
     */
    public function test_subscription_factory_creates_valid_subscription(): void
    {
        $subscription = Subscription::factory()->create();

        $this->assertNotNull($subscription->id);
        $this->assertNotNull($subscription->uuid);
        $this->assertContains($subscription->plan_key, Subscription::PLAN_KEYS);
        $this->assertContains($subscription->pickup_day, Subscription::PICKUP_DAYS);
        $this->assertDatabaseHas('subscriptions', ['id' => $subscription->id]);
    }

    /**
     * Test that the Subscription factory active state works.
     */
    public function test_subscription_factory_active_state_works(): void
    {
        $subscription = Subscription::factory()->active()->create();

        $this->assertEquals('active', $subscription->status);
        $this->assertTrue($subscription->isActive());
    }

    /**
     * Test that the Subscription factory paused state works.
     */
    public function test_subscription_factory_paused_state_works(): void
    {
        $subscription = Subscription::factory()->paused()->create();

        $this->assertEquals('paused', $subscription->status);
        $this->assertTrue($subscription->isPaused());
        $this->assertNotNull($subscription->paused_at);
        $this->assertNotNull($subscription->resume_at);
    }

    /**
     * Test that the Subscription factory cancelled state works.
     */
    public function test_subscription_factory_cancelled_state_works(): void
    {
        $subscription = Subscription::factory()->cancelled()->create();

        $this->assertEquals('cancelled', $subscription->status);
        $this->assertTrue($subscription->isCancelled());
        $this->assertNotNull($subscription->cancelled_at);
    }

    /**
     * Test that the Pickup factory creates a valid pickup.
     */
    public function test_pickup_factory_creates_valid_pickup(): void
    {
        $pickup = Pickup::factory()->create();

        $this->assertNotNull($pickup->id);
        $this->assertNotNull($pickup->uuid);
        $this->assertNotNull($pickup->scheduled_date);
        $this->assertDatabaseHas('pickups', ['id' => $pickup->id]);
    }

    /**
     * Test that the Pickup factory delivered state works.
     */
    public function test_pickup_factory_delivered_state_works(): void
    {
        $pickup = Pickup::factory()->delivered()->create();

        $this->assertEquals('delivered', $pickup->status);
        $this->assertTrue($pickup->isComplete());
        $this->assertNotNull($pickup->delivered_at);
    }

    /**
     * Test that the Bag factory creates a valid bag.
     */
    public function test_bag_factory_creates_valid_bag(): void
    {
        $bag = Bag::factory()->create();

        $this->assertNotNull($bag->id);
        $this->assertNotNull($bag->uuid);
        $this->assertNotNull($bag->qr_code);
        $this->assertStringStartsWith('LAU-', $bag->qr_code);
        $this->assertDatabaseHas('bags', ['id' => $bag->id]);
    }

    /**
     * Test that the Bag factory generates unique QR codes.
     */
    public function test_bag_factory_generates_unique_qr_codes(): void
    {
        $bag1 = Bag::factory()->create();
        $bag2 = Bag::factory()->create();

        $this->assertNotEquals($bag1->qr_code, $bag2->qr_code);
    }

    /**
     * Test that the Preferences factory creates valid preferences.
     */
    public function test_preferences_factory_creates_valid_preferences(): void
    {
        $preferences = Preferences::factory()->create();

        $this->assertNotNull($preferences->id);
        $this->assertContains($preferences->detergent, Preferences::DETERGENT_OPTIONS);
        $this->assertDatabaseHas('preferences', ['id' => $preferences->id]);
    }

    /**
     * Test that the Invoice factory creates a valid invoice.
     */
    public function test_invoice_factory_creates_valid_invoice(): void
    {
        $invoice = Invoice::factory()->create();

        $this->assertNotNull($invoice->id);
        $this->assertNotNull($invoice->uuid);
        $this->assertNotNull($invoice->invoice_number);
        $this->assertStringStartsWith('INV-', $invoice->invoice_number);
        $this->assertDatabaseHas('invoices', ['id' => $invoice->id]);
    }

    /**
     * Test that the Invoice factory generates unique invoice numbers.
     */
    public function test_invoice_factory_generates_unique_invoice_numbers(): void
    {
        $invoice1 = Invoice::factory()->create();
        $invoice2 = Invoice::factory()->create();

        $this->assertNotEquals($invoice1->invoice_number, $invoice2->invoice_number);
    }

    /**
     * Test that the NotificationPreferences factory creates valid preferences.
     */
    public function test_notification_preferences_factory_creates_valid_preferences(): void
    {
        $prefs = NotificationPreferences::factory()->create();

        $this->assertNotNull($prefs->id);
        $this->assertNotNull($prefs->user_id);
        $this->assertDatabaseHas('notification_preferences', ['id' => $prefs->id]);
    }
}
