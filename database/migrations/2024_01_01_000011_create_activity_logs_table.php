<?php

/**
 * File: 2024_01_01_000011_create_activity_logs_table.php
 * Description: Create the activity_logs table for admin audit trail
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
     * Creates the activity_logs table to provide an audit trail
     * for admin actions and model changes.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('action');                  // 'created', 'updated', 'deleted', etc.
            $table->string('subject_type');            // Model class name
            $table->unsignedBigInteger('subject_id');
            $table->json('properties')->nullable();    // Changed fields
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();

            $table->timestamps();

            $table->index(['subject_type', 'subject_id']);
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
