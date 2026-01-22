<?php

/**
 * File: 2024_01_01_000004_create_subscriptions_table.php
 * Description: Create the subscriptions table for laundry service subscription management
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates the subscriptions table to manage laundry service subscriptions.
     * Includes Stripe integration, billing cycles, pause/cancel handling, and dunning.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('address_id')->constrained()->cascadeOnDelete();

            $table->string('region_key', 50);
            $table->string('plan_key', 50);           // 'light', 'family', 'grand'
            $table->string('status', 20);             // 'active', 'paused', 'cancelled', 'past_due'
            $table->integer('bags_per_week');

            // Pickup day - assigned by admin during onboarding
            // Valid values: 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'
            // Validated in model/form request, not DB ENUM (SQLite compatibility)
            $table->string('pickup_day', 10);

            // Stripe integration
            $table->string('stripe_subscription_id')->nullable();
            $table->string('stripe_price_id')->nullable();
            $table->string('stripe_status')->nullable();

            // Billing cycle
            $table->timestamp('current_period_start')->nullable();
            $table->timestamp('current_period_end')->nullable();
            $table->timestamp('trial_ends_at')->nullable();

            // Pause handling
            $table->timestamp('paused_at')->nullable();
            $table->timestamp('resume_at')->nullable();
            $table->integer('pause_weeks')->nullable();

            // Cancellation
            $table->timestamp('cancelled_at')->nullable();
            $table->string('cancellation_reason')->nullable();
            $table->text('cancellation_feedback')->nullable();
            $table->boolean('cancel_at_period_end')->default(false);

            // Dunning
            $table->timestamp('dunning_started_at')->nullable();
            $table->integer('dunning_emails_sent')->default(0);

            // Tracking
            $table->string('promo_code')->nullable();
            $table->integer('skips_used_this_period')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status']);
            $table->index(['region_key', 'status']);
            $table->index('stripe_subscription_id');
            $table->index(['pickup_day', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
