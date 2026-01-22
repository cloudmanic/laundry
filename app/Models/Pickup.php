<?php

/**
 * File: Pickup.php
 * Description: Model for tracking laundry pickup and delivery lifecycle
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Pickup extends Model
{
    use HasFactory;

    /**
     * The valid pickup statuses.
     *
     * @var array
     */
    public const STATUSES = [
        'scheduled',
        'reminder_sent',
        'picked_up',
        'processing',
        'ready',
        'out_for_delivery',
        'delivered',
        'skipped',
        'missed',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
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
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'scheduled_date' => 'date',
            'bags_expected' => 'integer',
            'bags_collected' => 'integer',
            'reminder_sent_at' => 'datetime',
            'picked_up_at' => 'datetime',
            'processing_started_at' => 'datetime',
            'ready_at' => 'datetime',
            'out_for_delivery_at' => 'datetime',
            'delivered_at' => 'datetime',
            'skipped_at' => 'datetime',
        ];
    }

    /**
     * The "booted" method of the model.
     *
     * Automatically generates a UUID when creating a new pickup.
     */
    protected static function booted(): void
    {
        static::creating(function (Pickup $pickup) {
            if (empty($pickup->uuid)) {
                $pickup->uuid = (string) Str::uuid();
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
     * Get the subscription that this pickup belongs to.
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Get the address for this pickup.
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Get all bags associated with this pickup.
     */
    public function bags(): HasMany
    {
        return $this->hasMany(Bag::class);
    }

    /**
     * Check if the pickup is in a completed state.
     */
    public function isComplete(): bool
    {
        return in_array($this->status, ['delivered', 'skipped', 'missed']);
    }

    /**
     * Check if the pickup is still in progress.
     */
    public function isInProgress(): bool
    {
        return in_array($this->status, ['picked_up', 'processing', 'ready', 'out_for_delivery']);
    }

    /**
     * Check if the pickup is pending (not yet started).
     */
    public function isPending(): bool
    {
        return in_array($this->status, ['scheduled', 'reminder_sent']);
    }

    /**
     * Check if the pickup was skipped.
     */
    public function wasSkipped(): bool
    {
        return $this->status === 'skipped';
    }

    /**
     * Check if the pickup was missed.
     */
    public function wasMissed(): bool
    {
        return $this->status === 'missed';
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
     * Scope a query to only include scheduled pickups.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    /**
     * Scope a query to only include delivered pickups.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    /**
     * Scope a query to filter pickups for a specific date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('scheduled_date', $date);
    }

    /**
     * Scope a query to filter pickups scheduled for today.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToday($query)
    {
        return $query->whereDate('scheduled_date', today());
    }

    /**
     * Scope a query to filter pickups scheduled for the future.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpcoming($query)
    {
        return $query->whereDate('scheduled_date', '>=', today());
    }

    /**
     * Scope a query to filter pickups that need reminder notifications.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNeedsReminder($query)
    {
        return $query->where('status', 'scheduled')
            ->whereNull('reminder_sent_at');
    }
}
