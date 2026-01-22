<?php

/**
 * File: ResetPasswordNotification.php
 * Description: Custom branded password reset notification with region-specific styling
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-22
 */

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The password reset token.
     */
    public string $token;

    /**
     * Create a new notification instance.
     *
     * Stores the password reset token for inclusion in the email.
     *
     * @param  string  $token  The password reset token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable  The user being notified
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * Builds the branded password reset email using the custom email template
     * with region-specific styling and content.
     *
     * @param  mixed  $notifiable  The user being notified
     */
    public function toMail($notifiable): MailMessage
    {
        // Get the city configuration for branding
        $activeCity = config('city.active', 'sherwood');
        $city = config("city.cities.{$activeCity}");

        // Build the reset URL with token and email
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        // Log the password reset email being sent
        Log::info('Password reset email sent', [
            'user_id' => $notifiable->id ?? null,
            'email' => $notifiable->getEmailForPasswordReset(),
            'city' => $activeCity,
        ]);

        return (new MailMessage)
            ->subject('Reset Your '.$city['brand'].' Password')
            ->view('emails.reset-password', [
                'url' => $url,
                'user' => $notifiable,
                'city' => $city,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable  The user being notified
     * @return array<string, mixed>
     */
    public function toArray($notifiable): array
    {
        return [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ];
    }
}
