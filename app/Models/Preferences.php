<?php

/**
 * File: Preferences.php
 * Description: Model for user laundry preferences (detergent type, etc.)
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Preferences extends Model
{
    use HasFactory;

    /**
     * The valid detergent options.
     *
     * @var array
     */
    public const DETERGENT_OPTIONS = [
        'regular',
        'fragrance_free',
        'hypoallergenic',
        'eco_friendly',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'preferences';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'detergent',
    ];

    /**
     * Get the user that owns these preferences.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the user prefers regular detergent.
     */
    public function usesRegularDetergent(): bool
    {
        return $this->detergent === 'regular';
    }

    /**
     * Check if the user prefers fragrance-free detergent.
     */
    public function usesFragranceFree(): bool
    {
        return $this->detergent === 'fragrance_free';
    }

    /**
     * Check if the user prefers hypoallergenic detergent.
     */
    public function usesHypoallergenic(): bool
    {
        return $this->detergent === 'hypoallergenic';
    }

    /**
     * Check if the user prefers eco-friendly detergent.
     */
    public function usesEcoFriendly(): bool
    {
        return $this->detergent === 'eco_friendly';
    }

    /**
     * Get a human-readable label for the detergent preference.
     */
    public function getDetergentLabelAttribute(): string
    {
        return match ($this->detergent) {
            'regular' => 'Regular',
            'fragrance_free' => 'Fragrance Free',
            'hypoallergenic' => 'Hypoallergenic',
            'eco_friendly' => 'Eco Friendly',
            default => 'Unknown',
        };
    }
}
