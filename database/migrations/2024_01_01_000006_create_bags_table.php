<?php

/**
 * File: 2024_01_01_000006_create_bags_table.php
 * Description: Create the bags table for tracking individual laundry bags with QR codes
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
     * Creates the bags table to track individual laundry bags throughout
     * the processing lifecycle. Each bag has a unique QR code for scanning.
     */
    public function up(): void
    {
        Schema::create('bags', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('subscription_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pickup_id')->nullable()->constrained()->nullOnDelete();

            $table->string('qr_code')->unique();      // Unique bag identifier
            $table->string('status', 20)->default('with_customer');
            // Statuses: 'with_customer', 'picked_up', 'at_facility', 'washing',
            //           'drying', 'folding', 'ready', 'out_for_delivery', 'delivered'

            $table->string('label')->nullable();       // "Kids", "Master Bedroom"
            $table->json('scans')->nullable();         // History of scans with timestamps
            $table->timestamp('last_scanned_at')->nullable();
            $table->timestamps();

            $table->index(['subscription_id', 'status']);
            $table->index('qr_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bags');
    }
};
