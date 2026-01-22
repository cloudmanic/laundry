<?php

/**
 * File: 2024_01_01_000009_create_notification_preferences_table.php
 * Description: Create the notification_preferences table for user notification settings
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
     * Creates the notification_preferences table to store user preferences
     * for email, SMS, and push notifications.
     */
    public function up(): void
    {
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Email preferences
            $table->boolean('email_pickup_reminders')->default(true);
            $table->boolean('email_delivery_updates')->default(true);
            $table->boolean('email_billing')->default(true);
            $table->boolean('email_marketing')->default(false);

            // SMS preferences
            $table->boolean('sms_enabled')->default(false);
            $table->boolean('sms_pickup_reminders')->default(true);
            $table->boolean('sms_delivery_updates')->default(true);

            // Push preferences
            $table->boolean('push_enabled')->default(true);
            $table->boolean('push_pickup_reminders')->default(true);
            $table->boolean('push_delivery_updates')->default(true);

            $table->timestamps();

            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_preferences');
    }
};
