<?php

/**
 * File: VerifyEmailNotification.php
 * Description: Custom branded email verification notification with region-specific styling
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-22
 */

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * Initializes the email verification notification.
     */
    public function __construct()
    {
        //
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
     * Builds the branded email verification email using the custom email template
     * with region-specific styling and content.
     *
     * @param  mixed  $notifiable  The user being notified
     */
    public function toMail($notifiable): MailMessage
    {
        // Get the city configuration for branding
        $activeCity = config('city.active', 'sherwood');
        $city = config("city.cities.{$activeCity}");

        // Build the verification URL with signed expiration
        $verificationUrl = $this->verificationUrl($notifiable);

        // Log the verification email being sent
        Log::info('Email verification sent', [
            'user_id' => $notifiable->id ?? null,
            'email' => $notifiable->getEmailForVerification(),
            'city' => $activeCity,
        ]);

        return (new MailMessage)
            ->subject('Verify Your '.$city['brand'].' Email Address')
            ->view('emails.verify-email', [
                'url' => $verificationUrl,
                'user' => $notifiable,
                'city' => $city,
            ]);
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * Generates a signed URL that expires after 60 minutes for security.
     *
     * @param  mixed  $notifiable  The user being verified
     * @return string The signed verification URL
     */
    protected function verificationUrl($notifiable): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
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
            'email' => $notifiable->getEmailForVerification(),
            'verified_at' => null,
        ];
    }
}
