<?php

/**
 * File: 2024_01_01_000005_create_pickups_table.php
 * Description: Create the pickups table for tracking laundry pickup and delivery lifecycle
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
     * Creates the pickups table to track the full lifecycle of a laundry pickup
     * from scheduling through delivery, including timestamps for each status change.
     */
    public function up(): void
    {
        Schema::create('pickups', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('subscription_id')->constrained()->cascadeOnDelete();
            $table->foreignId('address_id')->constrained();

            $table->date('scheduled_date');
            $table->string('status', 20)->default('scheduled');
            // Statuses: 'scheduled', 'reminder_sent', 'picked_up', 'processing',
            //           'ready', 'out_for_delivery', 'delivered', 'skipped', 'missed'

            $table->integer('bags_expected');
            $table->integer('bags_collected')->nullable();

            // Timestamps for tracking
            $table->timestamp('reminder_sent_at')->nullable();
            $table->timestamp('picked_up_at')->nullable();
            $table->timestamp('processing_started_at')->nullable();
            $table->timestamp('ready_at')->nullable();
            $table->timestamp('out_for_delivery_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('skipped_at')->nullable();

            $table->string('skip_reason')->nullable();
            $table->text('driver_notes')->nullable();
            $table->string('delivery_photo_path')->nullable();

            $table->timestamps();

            $table->index(['subscription_id', 'scheduled_date']);
            $table->index(['scheduled_date', 'status']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pickups');
    }
};
