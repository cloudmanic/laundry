<?php

/**
 * File: MigrationTest.php
 * Description: Tests to verify all migrations run successfully on SQLite
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MigrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the users table has all required columns.
     */
    public function test_users_table_has_required_columns(): void
    {
        $this->assertTrue(Schema::hasTable('users'));

        $this->assertTrue(Schema::hasColumns('users', [
            'id',
            'uuid',
            'first_name',
            'last_name',
            'email',
            'email_verified_at',
            'password',
            'phone',
            'region_key',
            'stripe_customer_id',
            'timezone',
            'is_admin',
            'onboarding_completed_at',
            'remember_token',
            'created_at',
            'updated_at',
            'deleted_at',
        ]));
    }

    /**
     * Test that the social_accounts table exists with required columns.
     */
    public function test_social_accounts_table_has_required_columns(): void
    {
        $this->assertTrue(Schema::hasTable('social_accounts'));

        $this->assertTrue(Schema::hasColumns('social_accounts', [
            'id',
            'user_id',
            'provider',
            'provider_user_id',
            'provider_email',
            'token',
            'refresh_token',
            'token_expires_at',
            'created_at',
            'updated_at',
        ]));
    }

    /**
     * Test that the addresses table exists with required columns.
     */
    public function test_addresses_table_has_required_columns(): void
    {
        $this->assertTrue(Schema::hasTable('addresses'));

        $this->assertTrue(Schema::hasColumns('addresses', [
            'id',
            'uuid',
            'user_id',
            'label',
            'street_address',
            'unit',
            'city',
            'state',
            'zip_code',
            'delivery_instructions',
            'latitude',
            'longitude',
            'formatted_address',
            'place_id',
            'geocoded_at',
            'is_primary',
            'is_validated',
            'created_at',
            'updated_at',
            'deleted_at',
        ]));
    }

    /**
     * Test that the subscriptions table exists with required columns.
     */
    public function test_subscriptions_table_has_required_columns(): void
    {
        $this->assertTrue(Schema::hasTable('subscriptions'));

        $this->assertTrue(Schema::hasColumns('subscriptions', [
            'id',
            'uuid',
            'user_id',
            'address_id',
            'region_key',
            'plan_key',
            'status',
            'bags_per_week',
            'pickup_day',
            'stripe_subscription_id',
            'stripe_price_id',
            'stripe_status',
            'current_period_start',
            'current_period_end',
            'trial_ends_at',
            'paused_at',
            'resume_at',
            'pause_weeks',
            'cancelled_at',
            'cancellation_reason',
            'cancellation_feedback',
            'cancel_at_period_end',
            'dunning_started_at',
            'dunning_emails_sent',
            'promo_code',
            'skips_used_this_period',
            'created_at',
            'updated_at',
            'deleted_at',
        ]));
    }

    /**
     * Test that the pickups table exists with required columns.
     */
    public function test_pickups_table_has_required_columns(): void
    {
        $this->assertTrue(Schema::hasTable('pickups'));

        $this->assertTrue(Schema::hasColumns('pickups', [
            'id',
            'uuid',
            'subscription_id',
            'address_id',
            'scheduled_date',
            'status',
            'bags_expected',
            'bags_collected',
            'reminder_sent_at',
            'picked_up_at',
            'processing_started_at',
            'ready_at',
            'out_for_delivery_at',
            'delivered_at',
            'skipped_at',
            'skip_reason',
            'driver_notes',
            'delivery_photo_path',
            'created_at',
            'updated_at',
        ]));
    }

    /**
     * Test that the bags table exists with required columns.
     */
    public function test_bags_table_has_required_columns(): void
    {
        $this->assertTrue(Schema::hasTable('bags'));

        $this->assertTrue(Schema::hasColumns('bags', [
            'id',
            'uuid',
            'subscription_id',
            'pickup_id',
            'qr_code',
            'status',
            'label',
            'scans',
            'last_scanned_at',
            'created_at',
            'updated_at',
        ]));
    }

    /**
     * Test that the preferences table exists with required columns.
     */
    public function test_preferences_table_has_required_columns(): void
    {
        $this->assertTrue(Schema::hasTable('preferences'));

        $this->assertTrue(Schema::hasColumns('preferences', [
            'id',
            'user_id',
            'detergent',
            'created_at',
            'updated_at',
        ]));
    }

    /**
     * Test that the invoices table exists with required columns.
     */
    public function test_invoices_table_has_required_columns(): void
    {
        $this->assertTrue(Schema::hasTable('invoices'));

        $this->assertTrue(Schema::hasColumns('invoices', [
            'id',
            'uuid',
            'user_id',
            'subscription_id',
            'stripe_invoice_id',
            'invoice_number',
            'status',
            'subtotal_cents',
            'discount_cents',
            'tax_cents',
            'total_cents',
            'currency',
            'description',
            'period_start',
            'period_end',
            'due_date',
            'paid_at',
            'pdf_url',
            'created_at',
            'updated_at',
        ]));
    }

    /**
     * Test that the notification_preferences table exists with required columns.
     */
    public function test_notification_preferences_table_has_required_columns(): void
    {
        $this->assertTrue(Schema::hasTable('notification_preferences'));

        $this->assertTrue(Schema::hasColumns('notification_preferences', [
            'id',
            'user_id',
            'email_pickup_reminders',
            'email_delivery_updates',
            'email_billing',
            'email_marketing',
            'sms_enabled',
            'sms_pickup_reminders',
            'sms_delivery_updates',
            'push_enabled',
            'push_pickup_reminders',
            'push_delivery_updates',
            'created_at',
            'updated_at',
        ]));
    }

    /**
     * Test that the device_tokens table exists with required columns.
     */
    public function test_device_tokens_table_has_required_columns(): void
    {
        $this->assertTrue(Schema::hasTable('device_tokens'));

        $this->assertTrue(Schema::hasColumns('device_tokens', [
            'id',
            'user_id',
            'platform',
            'token',
            'is_active',
            'last_used_at',
            'created_at',
            'updated_at',
        ]));
    }

    /**
     * Test that the activity_logs table exists with required columns.
     */
    public function test_activity_logs_table_has_required_columns(): void
    {
        $this->assertTrue(Schema::hasTable('activity_logs'));

        $this->assertTrue(Schema::hasColumns('activity_logs', [
            'id',
            'user_id',
            'action',
            'subject_type',
            'subject_id',
            'properties',
            'ip_address',
            'user_agent',
            'created_at',
            'updated_at',
        ]));
    }

    /**
     * Test that the jobs table exists (Laravel queue).
     */
    public function test_jobs_table_exists(): void
    {
        $this->assertTrue(Schema::hasTable('jobs'));
        $this->assertTrue(Schema::hasTable('job_batches'));
        $this->assertTrue(Schema::hasTable('failed_jobs'));
    }
}
