<?php

/**
 * File: 2024_01_01_000007_create_preferences_table.php
 * Description: Create the preferences table for user laundry preferences
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
     * Creates the preferences table to store user laundry preferences
     * such as detergent type.
     */
    public function up(): void
    {
        Schema::create('preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('detergent')->default('regular');
            // Options: 'regular', 'fragrance_free', 'hypoallergenic', 'eco_friendly'

            $table->timestamps();

            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preferences');
    }
};
