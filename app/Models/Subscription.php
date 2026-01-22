<?php

/**
 * File: Subscription.php
 * Description: Model for laundry service subscriptions with Stripe integration
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The valid pickup days.
     *
     * @var array
     */
    public const PICKUP_DAYS = [
        'sunday',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
    ];

    /**
     * The valid subscription statuses.
     *
     * @var array
     */
    public const STATUSES = [
        'active',
        'paused',
        'cancelled',
        'past_due',
    ];

    /**
     * The valid plan keys.
     *
     * @var array
     */
    public const PLAN_KEYS = [
        'light',
        'family',
        'grand',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
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
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'bags_per_week' => 'integer',
            'current_period_start' => 'datetime',
            'current_period_end' => 'datetime',
            'trial_ends_at' => 'datetime',
            'paused_at' => 'datetime',
            'resume_at' => 'datetime',
            'pause_weeks' => 'integer',
            'cancelled_at' => 'datetime',
            'cancel_at_period_end' => 'boolean',
            'dunning_started_at' => 'datetime',
            'dunning_emails_sent' => 'integer',
            'skips_used_this_period' => 'integer',
        ];
    }

    /**
     * The "booted" method of the model.
     *
     * Automatically generates a UUID when creating a new subscription.
     */
    protected static function booted(): void
    {
        static::creating(function (Subscription $subscription) {
            if (empty($subscription->uuid)) {
                $subscription->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the route key for the model.
     *
     * Uses UUID for public-facing URLs instead of auto-increment ID.
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Get the user that owns this subscription.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the address associated with this subscription.
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Get all pickups for this subscription.
     */
    public function pickups(): HasMany
    {
        return $this->hasMany(Pickup::class);
    }

    /**
     * Get all bags for this subscription.
     */
    public function bags(): HasMany
    {
        return $this->hasMany(Bag::class);
    }

    /**
     * Get all invoices for this subscription.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the next pickup date based on the assigned pickup day.
     */
    public function getNextPickupDate(): Carbon
    {
        $pickupDay = $this->pickup_day;
        $now = now();

        // Find next occurrence of the pickup day
        $next = $now->copy()->next($pickupDay);

        // If it's today and before cutoff (8 AM), use today
        if ($now->is($pickupDay) && $now->hour < 8) {
            return $now->startOfDay();
        }

        return $next->startOfDay();
    }

    /**
     * Check if the subscription is currently active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if the subscription is currently paused.
     */
    public function isPaused(): bool
    {
        return $this->status === 'paused';
    }

    /**
     * Check if the subscription is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Check if the subscription is past due.
     */
    public function isPastDue(): bool
    {
        return $this->status === 'past_due';
    }

    /**
     * Check if the subscription is on a trial.
     */
    public function onTrial(): bool
    {
        return $this->trial_ends_at !== null && $this->trial_ends_at->isFuture();
    }

    /**
     * Check if the subscription is scheduled to cancel at period end.
     */
    public function willCancelAtPeriodEnd(): bool
    {
        return $this->cancel_at_period_end;
    }

    /**
     * Scope a query to filter by status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include active subscriptions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include paused subscriptions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaused($query)
    {
        return $query->where('status', 'paused');
    }

    /**
     * Scope a query to only include cancelled subscriptions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Scope a query to filter by region.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForRegion($query, string $regionKey)
    {
        return $query->where('region_key', $regionKey);
    }

    /**
     * Scope a query to filter by pickup day.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForPickupDay($query, string $day)
    {
        return $query->where('pickup_day', $day);
    }

    /**
     * Scope a query to filter by plan.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForPlan($query, string $planKey)
    {
        return $query->where('plan_key', $planKey);
    }

    /**
     * Scope a query to only include subscriptions in dunning.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInDunning($query)
    {
        return $query->whereNotNull('dunning_started_at');
    }

    /**
     * Scope a query to only include subscriptions scheduled to resume.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeScheduledToResume($query)
    {
        return $query->whereNotNull('resume_at');
    }
}
