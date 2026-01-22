<?php

/**
 * File: 2024_01_01_000002_create_social_accounts_table.php
 * Description: Create the social_accounts table for OAuth login (Google/Apple)
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
     * Creates the social_accounts table to store OAuth provider information
     * for Google and Apple sign-in functionality.
     */
    public function up(): void
    {
        Schema::create('social_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('provider');           // 'google', 'apple'
            $table->string('provider_user_id');
            $table->string('provider_email')->nullable();
            $table->text('token')->nullable();
            $table->text('refresh_token')->nullable();
            $table->timestamp('token_expires_at')->nullable();
            $table->timestamps();

            $table->unique(['provider', 'provider_user_id']);
            $table->index(['user_id', 'provider']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_accounts');
    }
};
