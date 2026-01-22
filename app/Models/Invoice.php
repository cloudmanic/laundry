<?php

/**
 * File: Invoice.php
 * Description: Model for Stripe invoice synchronization
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The valid invoice statuses.
     *
     * @var array
     */
    public const STATUSES = [
        'draft',
        'open',
        'paid',
        'void',
        'uncollectible',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
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
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'subtotal_cents' => 'integer',
            'discount_cents' => 'integer',
            'tax_cents' => 'integer',
            'total_cents' => 'integer',
            'period_start' => 'datetime',
            'period_end' => 'datetime',
            'due_date' => 'datetime',
            'paid_at' => 'datetime',
        ];
    }

    /**
     * The "booted" method of the model.
     *
     * Automatically generates a UUID and invoice number when creating.
     */
    protected static function booted(): void
    {
        static::creating(function (Invoice $invoice) {
            if (empty($invoice->uuid)) {
                $invoice->uuid = (string) Str::uuid();
            }
            if (empty($invoice->invoice_number)) {
                $invoice->invoice_number = self::generateInvoiceNumber();
            }
        });
    }

    /**
     * Generate a unique invoice number.
     *
     * Format: INV-YYYYMM-XXXXX (where X is a sequential number)
     */
    public static function generateInvoiceNumber(): string
    {
        $prefix = 'INV-'.now()->format('Ym').'-';
        $lastInvoice = static::where('invoice_number', 'like', $prefix.'%')
            ->orderBy('invoice_number', 'desc')
            ->first();

        if ($lastInvoice) {
            $lastNumber = (int) substr($lastInvoice->invoice_number, -5);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return $prefix.str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
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
     * Get the user that owns this invoice.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subscription associated with this invoice.
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    /**
     * Get the subtotal amount in dollars.
     */
    public function getSubtotalAttribute(): float
    {
        return $this->subtotal_cents / 100;
    }

    /**
     * Get the discount amount in dollars.
     */
    public function getDiscountAttribute(): float
    {
        return $this->discount_cents / 100;
    }

    /**
     * Get the tax amount in dollars.
     */
    public function getTaxAttribute(): float
    {
        return $this->tax_cents / 100;
    }

    /**
     * Get the total amount in dollars.
     */
    public function getTotalAttribute(): float
    {
        return $this->total_cents / 100;
    }

    /**
     * Get the formatted total as a currency string.
     */
    public function getFormattedTotalAttribute(): string
    {
        return '$'.number_format($this->total, 2);
    }

    /**
     * Check if the invoice is paid.
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * Check if the invoice is open (awaiting payment).
     */
    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    /**
     * Check if the invoice is void.
     */
    public function isVoid(): bool
    {
        return $this->status === 'void';
    }

    /**
     * Check if the invoice is past due.
     */
    public function isPastDue(): bool
    {
        return $this->status === 'open'
            && $this->due_date !== null
            && $this->due_date->isPast();
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
     * Scope a query to only include paid invoices.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope a query to only include open invoices.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    /**
     * Scope a query to only include past due invoices.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePastDue($query)
    {
        return $query->where('status', 'open')
            ->whereNotNull('due_date')
            ->where('due_date', '<', now());
    }
}
