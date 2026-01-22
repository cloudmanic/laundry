<?php

/**
 * File: UserSeeder.php
 * Description: Seed the database with test users for development
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace Database\Seeders;

use App\Models\Address;
use App\Models\NotificationPreferences;
use App\Models\Preferences;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates test accounts for development:
     * - Admin user
     * - Test customers with various subscription states
     */
    public function run(): void
    {
        // 1. Create admin user
        $admin = User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@sherwoodlaundry.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'onboarding_completed_at' => now(),
            'region_key' => 'sherwood',
        ]);

        // Create notification preferences for admin
        NotificationPreferences::factory()->create([
            'user_id' => $admin->id,
        ]);

        // 2. Create test customer with Monday pickup (will get active subscription in SubscriptionSeeder)
        $mondayCustomer = User::factory()->create([
            'first_name' => 'Monday',
            'last_name' => 'Customer',
            'email' => 'monday@example.com',
            'password' => Hash::make('password'),
            'onboarding_completed_at' => now(),
            'region_key' => 'sherwood',
        ]);

        Address::factory()->create([
            'user_id' => $mondayCustomer->id,
            'label' => 'Home',
            'street_address' => '123 Oak Street',
            'city' => 'Sherwood',
            'state' => 'OR',
            'zip_code' => '97140',
            'is_primary' => true,
        ]);

        Preferences::factory()->regular()->create([
            'user_id' => $mondayCustomer->id,
        ]);

        NotificationPreferences::factory()->create([
            'user_id' => $mondayCustomer->id,
        ]);

        // 3. Create test customer with Wednesday pickup
        $wednesdayCustomer = User::factory()->create([
            'first_name' => 'Wednesday',
            'last_name' => 'Customer',
            'email' => 'wednesday@example.com',
            'password' => Hash::make('password'),
            'onboarding_completed_at' => now(),
            'region_key' => 'sherwood',
        ]);

        Address::factory()->create([
            'user_id' => $wednesdayCustomer->id,
            'label' => 'Home',
            'street_address' => '456 Maple Avenue',
            'city' => 'Sherwood',
            'state' => 'OR',
            'zip_code' => '97140',
            'is_primary' => true,
        ]);

        Preferences::factory()->fragranceFree()->create([
            'user_id' => $wednesdayCustomer->id,
        ]);

        NotificationPreferences::factory()->withSms()->create([
            'user_id' => $wednesdayCustomer->id,
        ]);

        // 4. Create test customer with paused subscription
        $pausedCustomer = User::factory()->create([
            'first_name' => 'Paused',
            'last_name' => 'Customer',
            'email' => 'paused@example.com',
            'password' => Hash::make('password'),
            'onboarding_completed_at' => now(),
            'region_key' => 'sherwood',
        ]);

        Address::factory()->create([
            'user_id' => $pausedCustomer->id,
            'label' => 'Home',
            'street_address' => '789 Pine Lane',
            'city' => 'Sherwood',
            'state' => 'OR',
            'zip_code' => '97140',
            'is_primary' => true,
        ]);

        Preferences::factory()->hypoallergenic()->create([
            'user_id' => $pausedCustomer->id,
        ]);

        NotificationPreferences::factory()->create([
            'user_id' => $pausedCustomer->id,
        ]);

        // 5. Create test customer with no subscription (new signup)
        $newCustomer = User::factory()->create([
            'first_name' => 'New',
            'last_name' => 'Signup',
            'email' => 'new@example.com',
            'password' => Hash::make('password'),
            'onboarding_completed_at' => null,
            'region_key' => 'sherwood',
        ]);

        NotificationPreferences::factory()->essentialOnly()->create([
            'user_id' => $newCustomer->id,
        ]);

        // 6. Create a few more random users for testing pagination, etc.
        User::factory()
            ->count(5)
            ->onboarded()
            ->create()
            ->each(function ($user) {
                Address::factory()->create(['user_id' => $user->id]);
                Preferences::factory()->create(['user_id' => $user->id]);
                NotificationPreferences::factory()->create(['user_id' => $user->id]);
            });
    }
}
