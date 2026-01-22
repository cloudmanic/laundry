<?php

/**
 * File: NotificationPreferencesFactory.php
 * Description: Factory for generating test NotificationPreferences data
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace Database\Factories;

use App\Models\NotificationPreferences;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NotificationPreferences>
 */
class NotificationPreferencesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NotificationPreferences::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'email_pickup_reminders' => true,
            'email_delivery_updates' => true,
            'email_billing' => true,
            'email_marketing' => false,
            'sms_enabled' => false,
            'sms_pickup_reminders' => true,
            'sms_delivery_updates' => true,
            'push_enabled' => true,
            'push_pickup_reminders' => true,
            'push_delivery_updates' => true,
        ];
    }

    /**
     * Indicate that all notifications are enabled.
     */
    public function allEnabled(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_pickup_reminders' => true,
            'email_delivery_updates' => true,
            'email_billing' => true,
            'email_marketing' => true,
            'sms_enabled' => true,
            'sms_pickup_reminders' => true,
            'sms_delivery_updates' => true,
            'push_enabled' => true,
            'push_pickup_reminders' => true,
            'push_delivery_updates' => true,
        ]);
    }

    /**
     * Indicate that all notifications are disabled.
     */
    public function allDisabled(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_pickup_reminders' => false,
            'email_delivery_updates' => false,
            'email_billing' => false,
            'email_marketing' => false,
            'sms_enabled' => false,
            'sms_pickup_reminders' => false,
            'sms_delivery_updates' => false,
            'push_enabled' => false,
            'push_pickup_reminders' => false,
            'push_delivery_updates' => false,
        ]);
    }

    /**
     * Indicate that SMS is enabled.
     */
    public function withSms(): static
    {
        return $this->state(fn (array $attributes) => [
            'sms_enabled' => true,
            'sms_pickup_reminders' => true,
            'sms_delivery_updates' => true,
        ]);
    }

    /**
     * Indicate that push notifications are disabled.
     */
    public function withoutPush(): static
    {
        return $this->state(fn (array $attributes) => [
            'push_enabled' => false,
        ]);
    }

    /**
     * Indicate that marketing emails are opted in.
     */
    public function withMarketing(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_marketing' => true,
        ]);
    }

    /**
     * Indicate that only essential notifications are enabled.
     */
    public function essentialOnly(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_pickup_reminders' => true,
            'email_delivery_updates' => true,
            'email_billing' => true,
            'email_marketing' => false,
            'sms_enabled' => false,
            'sms_pickup_reminders' => false,
            'sms_delivery_updates' => false,
            'push_enabled' => false,
            'push_pickup_reminders' => false,
            'push_delivery_updates' => false,
        ]);
    }
}
