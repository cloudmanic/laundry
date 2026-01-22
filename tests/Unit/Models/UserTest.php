<?php

/**
 * File: UserTest.php
 * Description: Unit tests for the User model
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace Tests\Unit\Models;

use App\Models\Address;
use App\Models\DeviceToken;
use App\Models\Invoice;
use App\Models\NotificationPreferences;
use App\Models\Preferences;
use App\Models\SocialAccount;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a UUID is auto-generated when creating a user.
     */
    public function test_uuid_is_auto_generated(): void
    {
        $user = User::factory()->create(['uuid' => null]);

        $this->assertNotNull($user->uuid);
        $this->assertMatchesRegularExpression(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i',
            $user->uuid
        );
    }

    /**
     * Test the full_name accessor.
     */
    public function test_full_name_accessor(): void
    {
        $user = User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        $this->assertEquals('John Doe', $user->full_name);
    }

    /**
     * Test the route key name is uuid.
     */
    public function test_route_key_name_is_uuid(): void
    {
        $user = new User;

        $this->assertEquals('uuid', $user->getRouteKeyName());
    }

    /**
     * Test the socialAccounts relationship.
     */
    public function test_social_accounts_relationship(): void
    {
        $user = User::factory()->create();
        SocialAccount::factory()->google()->create(['user_id' => $user->id]);
        SocialAccount::factory()->apple()->create(['user_id' => $user->id]);

        $this->assertCount(2, $user->socialAccounts);
        $this->assertInstanceOf(SocialAccount::class, $user->socialAccounts->first());
    }

    /**
     * Test the addresses relationship.
     */
    public function test_addresses_relationship(): void
    {
        $user = User::factory()->create();
        Address::factory()->count(2)->create(['user_id' => $user->id]);

        $this->assertCount(2, $user->addresses);
        $this->assertInstanceOf(Address::class, $user->addresses->first());
    }

    /**
     * Test the activeSubscription relationship.
     */
    public function test_active_subscription_relationship(): void
    {
        $user = User::factory()->create();
        $address = Address::factory()->create(['user_id' => $user->id]);

        Subscription::factory()->cancelled()->create([
            'user_id' => $user->id,
            'address_id' => $address->id,
        ]);

        $activeSubscription = Subscription::factory()->active()->create([
            'user_id' => $user->id,
            'address_id' => $address->id,
        ]);

        $this->assertNotNull($user->activeSubscription);
        $this->assertEquals($activeSubscription->id, $user->activeSubscription->id);
    }

    /**
     * Test the subscriptions relationship.
     */
    public function test_subscriptions_relationship(): void
    {
        $user = User::factory()->create();
        $address = Address::factory()->create(['user_id' => $user->id]);

        Subscription::factory()->count(3)->create([
            'user_id' => $user->id,
            'address_id' => $address->id,
        ]);

        $this->assertCount(3, $user->subscriptions);
    }

    /**
     * Test the preferences relationship.
     */
    public function test_preferences_relationship(): void
    {
        $user = User::factory()->create();
        Preferences::factory()->create(['user_id' => $user->id]);

        $this->assertNotNull($user->preferences);
        $this->assertInstanceOf(Preferences::class, $user->preferences);
    }

    /**
     * Test the invoices relationship.
     */
    public function test_invoices_relationship(): void
    {
        $user = User::factory()->create();
        Invoice::factory()->count(2)->create(['user_id' => $user->id]);

        $this->assertCount(2, $user->invoices);
    }

    /**
     * Test the notificationPreferences relationship.
     */
    public function test_notification_preferences_relationship(): void
    {
        $user = User::factory()->create();
        NotificationPreferences::factory()->create(['user_id' => $user->id]);

        $this->assertNotNull($user->notificationPreferences);
        $this->assertInstanceOf(NotificationPreferences::class, $user->notificationPreferences);
    }

    /**
     * Test the deviceTokens relationship.
     */
    public function test_device_tokens_relationship(): void
    {
        $user = User::factory()->create();
        DeviceToken::factory()->count(2)->create(['user_id' => $user->id]);

        $this->assertCount(2, $user->deviceTokens);
    }

    /**
     * Test the admins scope.
     */
    public function test_admins_scope(): void
    {
        User::factory()->count(3)->create(['is_admin' => false]);
        User::factory()->count(2)->create(['is_admin' => true]);

        $admins = User::admins()->get();

        $this->assertCount(2, $admins);
        $this->assertTrue($admins->every(fn ($user) => $user->is_admin));
    }

    /**
     * Test the forRegion scope.
     */
    public function test_for_region_scope(): void
    {
        User::factory()->count(2)->create(['region_key' => 'sherwood']);
        User::factory()->count(3)->create(['region_key' => 'bend']);

        $sherwoodUsers = User::forRegion('sherwood')->get();
        $bendUsers = User::forRegion('bend')->get();

        $this->assertCount(2, $sherwoodUsers);
        $this->assertCount(3, $bendUsers);
    }

    /**
     * Test the onboarded scope.
     */
    public function test_onboarded_scope(): void
    {
        User::factory()->count(2)->create(['onboarding_completed_at' => null]);
        User::factory()->count(3)->create(['onboarding_completed_at' => now()]);

        $onboarded = User::onboarded()->get();

        $this->assertCount(3, $onboarded);
    }

    /**
     * Test the pendingOnboarding scope.
     */
    public function test_pending_onboarding_scope(): void
    {
        User::factory()->count(2)->create(['onboarding_completed_at' => null]);
        User::factory()->count(3)->create(['onboarding_completed_at' => now()]);

        $pending = User::pendingOnboarding()->get();

        $this->assertCount(2, $pending);
    }

    /**
     * Test hasCompletedOnboarding method.
     */
    public function test_has_completed_onboarding_method(): void
    {
        $onboardedUser = User::factory()->create(['onboarding_completed_at' => now()]);
        $pendingUser = User::factory()->create(['onboarding_completed_at' => null]);

        $this->assertTrue($onboardedUser->hasCompletedOnboarding());
        $this->assertFalse($pendingUser->hasCompletedOnboarding());
    }

    /**
     * Test hasActiveSubscription method.
     */
    public function test_has_active_subscription_method(): void
    {
        $userWithSub = User::factory()->create();
        $userWithoutSub = User::factory()->create();

        $address = Address::factory()->create(['user_id' => $userWithSub->id]);
        Subscription::factory()->active()->create([
            'user_id' => $userWithSub->id,
            'address_id' => $address->id,
        ]);

        $this->assertTrue($userWithSub->hasActiveSubscription());
        $this->assertFalse($userWithoutSub->hasActiveSubscription());
    }

    /**
     * Test primaryAddress method.
     */
    public function test_primary_address_method(): void
    {
        $user = User::factory()->create();
        Address::factory()->create(['user_id' => $user->id, 'is_primary' => false]);
        $primaryAddress = Address::factory()->create(['user_id' => $user->id, 'is_primary' => true]);

        $result = $user->primaryAddress();

        $this->assertNotNull($result);
        $this->assertEquals($primaryAddress->id, $result->id);
    }

    /**
     * Test soft deletes work correctly.
     */
    public function test_soft_deletes_work(): void
    {
        $user = User::factory()->create();
        $userId = $user->id;

        $user->delete();

        $this->assertSoftDeleted('users', ['id' => $userId]);
        $this->assertNull(User::find($userId));
        $this->assertNotNull(User::withTrashed()->find($userId));
    }
}
