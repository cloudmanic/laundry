<?php

/**
 * File: Bag.php
 * Description: Model for tracking individual laundry bags with QR codes
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Bag extends Model
{
    use HasFactory;

    /**
     * The valid bag statuses.
     *
     * @var array
     */
    public const STATUSES = [
        'with_customer',
        'picked_up',
        'at_facility',
        'washing',
        'drying',
        'folding',
        'ready',
        'out_for_delivery',
        'delivered',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'uuid',
        'subscription_id',
        'pickup_id',
        'qr_code',
        'status',
        'label',
        'scans',
        'last_scanned_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'scans' => 'array',
            'last_scanned_at' => 'datetime',
        ];
    }

    /**
     * The "booted" method of the model.
     *
     * Automatically generates a UUID and QR code when creating a new bag.
     */
    protected static function booted(): void
    {
        static::creating(function (Bag $bag) {
            if (empty($bag->uuid)) {
                $bag->uuid = (string) Str::uuid();
            }
            if (empty($bag->qr_code)) {
                $bag->qr_code = self::generateQrCode();
            }
        });
    }

    /**
     * Generate a unique QR code for a bag.
     *
     * Format: LAU-XXXXXX (where X is alphanumeric)
     */
    public static function generateQrCode(): string
    {
        do {
            $code = 'LAU-'.strtoupper(Str::random(6));
        } while (static::where('qr_code', $code)->exists());

        return $code;
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
     * Get the subscription that owns this bag.
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Get the pickup that this bag is currently associated with.
     */
    public function pickup(): BelongsTo
    {
        return $this->belongsTo(Pickup::class);
    }

    /**
     * Record a scan for this bag.
     */
    public function recordScan(string $location, ?string $scannedBy = null): void
    {
        $scans = $this->scans ?? [];
        $scans[] = [
            'location' => $location,
            'scanned_by' => $scannedBy,
            'scanned_at' => now()->toIso8601String(),
        ];

        $this->update([
            'scans' => $scans,
            'last_scanned_at' => now(),
        ]);
    }

    /**
     * Check if the bag is currently with the customer.
     */
    public function isWithCustomer(): bool
    {
        return $this->status === 'with_customer';
    }

    /**
     * Check if the bag is being processed at the facility.
     */
    public function isBeingProcessed(): bool
    {
        return in_array($this->status, ['at_facility', 'washing', 'drying', 'folding']);
    }

    /**
     * Check if the bag is ready for delivery.
     */
    public function isReadyForDelivery(): bool
    {
        return $this->status === 'ready';
    }

    /**
     * Check if the bag has been delivered.
     */
    public function isDelivered(): bool
    {
        return $this->status === 'delivered';
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
     * Scope a query to only include bags with the customer.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithCustomer($query)
    {
        return $query->where('status', 'with_customer');
    }

    /**
     * Scope a query to only include bags being processed.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBeingProcessed($query)
    {
        return $query->whereIn('status', ['at_facility', 'washing', 'drying', 'folding']);
    }

    /**
     * Scope a query to only include bags ready for delivery.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeReady($query)
    {
        return $query->where('status', 'ready');
    }

    /**
     * Find a bag by its QR code.
     */
    public static function findByQrCode(string $qrCode): ?self
    {
        return static::where('qr_code', $qrCode)->first();
    }
}
