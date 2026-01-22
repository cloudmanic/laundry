<?php

/**
 * File: 2024_01_01_000001_modify_users_table.php
 * Description: Modify the users table to add fields for the laundry service application
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds additional fields to the users table for the laundry service:
     * - uuid: Public-facing identifier
     * - first_name/last_name: Replace the 'name' column
     * - phone: Contact number
     * - region_key: Multi-region support
     * - stripe_customer_id: Payment integration
     * - timezone: User timezone preference
     * - is_admin: Admin flag
     * - onboarding_completed_at: Track onboarding completion
     * - soft deletes
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Additional fields
            $table->uuid('uuid')->unique()->after('id');
            $table->string('first_name')->after('email');
            $table->string('last_name')->after('first_name');
            $table->string('phone', 20)->nullable()->after('last_name');
            $table->string('region_key', 50)->default('sherwood')->after('phone');
            $table->string('stripe_customer_id')->nullable()->after('region_key');
            $table->string('timezone')->default('America/Los_Angeles')->after('stripe_customer_id');
            $table->boolean('is_admin')->default(false)->after('timezone');
            $table->timestamp('onboarding_completed_at')->nullable()->after('is_admin');
            $table->softDeletes();

            // Indexes
            $table->index('region_key');
            $table->index('stripe_customer_id');
        });

        // Remove 'name' column (we use first_name + last_name)
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add name column back with default (required for SQLite with existing data)
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->default('')->after('id');
        });

        // Populate name from first_name + last_name
        DB::table('users')->get()->each(function ($user) {
            DB::table('users')
                ->where('id', $user->id)
                ->update(['name' => trim($user->first_name.' '.$user->last_name)]);
        });

        // Remove the default constraint by recreating without it (SQLite limitation)
        // For SQLite, we'll leave the default in place as it's acceptable for rollback

        // Drop indexes first (required for SQLite)
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['uuid']);
            $table->dropIndex(['region_key']);
            $table->dropIndex(['stripe_customer_id']);
        });

        // Drop columns in separate statement
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'uuid',
                'first_name',
                'last_name',
                'phone',
                'region_key',
                'stripe_customer_id',
                'timezone',
                'is_admin',
                'onboarding_completed_at',
                'deleted_at',
            ]);
        });
    }
};
