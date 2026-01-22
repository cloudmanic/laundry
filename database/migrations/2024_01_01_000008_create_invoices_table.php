<?php

/**
 * File: 2024_01_01_000008_create_invoices_table.php
 * Description: Create the invoices table for Stripe invoice synchronization
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Creates the invoices table to store synchronized Stripe invoices
     * with billing period and payment status information.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subscription_id')->nullable()->constrained()->nullOnDelete();

            $table->string('stripe_invoice_id')->nullable();
            $table->string('invoice_number')->unique();
            $table->string('status', 20);             // 'draft', 'open', 'paid', 'void', 'uncollectible'

            $table->integer('subtotal_cents');
            $table->integer('discount_cents')->default(0);
            $table->integer('tax_cents')->default(0);
            $table->integer('total_cents');

            $table->string('currency', 3)->default('usd');
            $table->text('description')->nullable();

            $table->timestamp('period_start')->nullable();
            $table->timestamp('period_end')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->string('pdf_url')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('stripe_invoice_id');
            $table->index('invoice_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
