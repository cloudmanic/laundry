<?php

/**
 * File: DatabaseSeeder.php
 * Description: Main database seeder that orchestrates all seeders
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * This seeder orchestrates all other seeders in the correct order.
     * Run with: php artisan db:seed
     * Or fresh migrate with seed: php artisan migrate:fresh --seed
     */
    public function run(): void
    {
        // 1. Create test users with addresses, preferences, and notification settings
        $this->call(UserSeeder::class);

        // 2. Create subscriptions, pickups, bags, and invoices for test users
        $this->call(SubscriptionSeeder::class);
    }
}
