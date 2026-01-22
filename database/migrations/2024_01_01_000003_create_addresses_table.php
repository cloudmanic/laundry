<?php

/**
 * File: 2024_01_01_000003_create_addresses_table.php
 * Description: Create the addresses table for user delivery addresses with geocoding support
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
     * Creates the addresses table to store user delivery addresses.
     * Includes geocoding fields for future route optimization.
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('label')->default('Home');  // "Home", "Work", "Other"
            $table->string('street_address');
            $table->string('unit')->nullable();        // Apt, Suite, etc.
            $table->string('city');
            $table->string('state', 2);
            $table->string('zip_code', 10);
            $table->text('delivery_instructions')->nullable();

            // Geocoding data (for future route optimization)
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('formatted_address')->nullable();
            $table->string('place_id')->nullable();    // Google Place ID
            $table->timestamp('geocoded_at')->nullable();

            $table->boolean('is_primary')->default(false);
            $table->boolean('is_validated')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'is_primary']);
            $table->index('zip_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
