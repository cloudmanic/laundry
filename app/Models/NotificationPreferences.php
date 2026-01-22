<?php

/**
 * File: NotificationPreferences.php
 * Description: Model for user notification settings (email, SMS, push)
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationPreferences extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notification_preferences';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
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
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_pickup_reminders' => 'boolean',
            'email_delivery_updates' => 'boolean',
            'email_billing' => 'boolean',
            'email_marketing' => 'boolean',
            'sms_enabled' => 'boolean',
            'sms_pickup_reminders' => 'boolean',
            'sms_delivery_updates' => 'boolean',
            'push_enabled' => 'boolean',
            'push_pickup_reminders' => 'boolean',
            'push_delivery_updates' => 'boolean',
        ];
    }

    /**
     * Get the user that owns these notification preferences.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the user wants pickup reminders via any channel.
     */
    public function wantsPickupReminders(): bool
    {
        return $this->email_pickup_reminders
            || ($this->sms_enabled && $this->sms_pickup_reminders)
            || ($this->push_enabled && $this->push_pickup_reminders);
    }

    /**
     * Check if the user wants delivery updates via any channel.
     */
    public function wantsDeliveryUpdates(): bool
    {
        return $this->email_delivery_updates
            || ($this->sms_enabled && $this->sms_delivery_updates)
            || ($this->push_enabled && $this->push_delivery_updates);
    }

    /**
     * Check if SMS is enabled for this user.
     */
    public function hasSmsEnabled(): bool
    {
        return $this->sms_enabled;
    }

    /**
     * Check if push notifications are enabled for this user.
     */
    public function hasPushEnabled(): bool
    {
        return $this->push_enabled;
    }

    /**
     * Check if the user has opted into marketing emails.
     */
    public function wantsMarketingEmails(): bool
    {
        return $this->email_marketing;
    }

    /**
     * Get the channels that should receive pickup reminders.
     */
    public function pickupReminderChannels(): array
    {
        $channels = [];

        if ($this->email_pickup_reminders) {
            $channels[] = 'email';
        }
        if ($this->sms_enabled && $this->sms_pickup_reminders) {
            $channels[] = 'sms';
        }
        if ($this->push_enabled && $this->push_pickup_reminders) {
            $channels[] = 'push';
        }

        return $channels;
    }

    /**
     * Get the channels that should receive delivery updates.
     */
    public function deliveryUpdateChannels(): array
    {
        $channels = [];

        if ($this->email_delivery_updates) {
            $channels[] = 'email';
        }
        if ($this->sms_enabled && $this->sms_delivery_updates) {
            $channels[] = 'sms';
        }
        if ($this->push_enabled && $this->push_delivery_updates) {
            $channels[] = 'push';
        }

        return $channels;
    }
}
