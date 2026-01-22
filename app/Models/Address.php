<?php

/**
 * File: Address.php
 * Description: Model for user delivery addresses with geocoding support
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The valid address labels.
     *
     * @var array
     */
    public const LABELS = [
        'Home',
        'Work',
        'Other',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
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
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'geocoded_at' => 'datetime',
            'is_primary' => 'boolean',
            'is_validated' => 'boolean',
        ];
    }

    /**
     * The "booted" method of the model.
     *
     * Automatically generates a UUID when creating a new address.
     */
    protected static function booted(): void
    {
        static::creating(function (Address $address) {
            if (empty($address->uuid)) {
                $address->uuid = (string) Str::uuid();
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
     * Get the user that owns this address.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all subscriptions using this address.
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get the full address as a single line.
     */
    public function getFullAddressAttribute(): string
    {
        $parts = [$this->street_address];

        if ($this->unit) {
            $parts[] = $this->unit;
        }

        $parts[] = "{$this->city}, {$this->state} {$this->zip_code}";

        return implode(', ', $parts);
    }

    /**
     * Check if the address has been geocoded.
     */
    public function isGeocoded(): bool
    {
        return $this->latitude !== null && $this->longitude !== null;
    }

    /**
     * Scope a query to only include primary addresses.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope a query to only include validated addresses.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeValidated($query)
    {
        return $query->where('is_validated', true);
    }

    /**
     * Scope a query to filter addresses by zip code.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInZipCode($query, string $zipCode)
    {
        return $query->where('zip_code', $zipCode);
    }

    /**
     * Scope a query to filter addresses by city.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInCity($query, string $city)
    {
        return $query->where('city', $city);
    }
}
