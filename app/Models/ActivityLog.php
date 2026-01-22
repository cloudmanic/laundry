<?php

/**
 * File: ActivityLog.php
 * Description: Model for admin audit trail and activity logging
 * Copyright: 2026 Cloudmanic Labs, LLC
 * Date: 2026-01-21
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    /**
     * The valid actions.
     *
     * @var array
     */
    public const ACTIONS = [
        'created',
        'updated',
        'deleted',
        'restored',
        'logged_in',
        'logged_out',
        'exported',
        'imported',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'action',
        'subject_type',
        'subject_id',
        'properties',
        'ip_address',
        'user_agent',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'properties' => 'array',
        ];
    }

    /**
     * Get the user that performed the action.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subject of the activity (polymorphic).
     */
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Log an activity.
     *
     * @param  string  $action  The action performed
     * @param  Model|null  $subject  The model being acted upon
     * @param  array|null  $properties  Additional properties to log
     * @param  User|null  $user  The user performing the action (defaults to auth user)
     */
    public static function log(
        string $action,
        ?Model $subject = null,
        ?array $properties = null,
        ?User $user = null
    ): self {
        return static::create([
            'user_id' => $user?->id ?? auth()->id(),
            'action' => $action,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject?->id,
            'properties' => $properties,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Get a human-readable description of the activity.
     */
    public function getDescriptionAttribute(): string
    {
        $userName = $this->user?->full_name ?? 'System';
        $subjectName = class_basename($this->subject_type ?? 'Unknown');

        return "{$userName} {$this->action} {$subjectName} #{$this->subject_id}";
    }

    /**
     * Scope a query to filter by action.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope a query to filter by subject type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForSubjectType($query, string $type)
    {
        return $query->where('subject_type', $type);
    }

    /**
     * Scope a query to filter by subject.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForSubject($query, Model $subject)
    {
        return $query->where('subject_type', get_class($subject))
            ->where('subject_id', $subject->id);
    }

    /**
     * Scope a query to filter by user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  User|int  $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUser($query, $user)
    {
        $userId = $user instanceof User ? $user->id : $user;

        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to filter activities from today.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope a query to filter activities from the last N days.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLastDays($query, int $days)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
