<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'likes_count' => 'integer',
    ];

    /**
     * Get the parent model that was commented on.
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Check if this comment is a reply.
     */
    public function isReply(): bool
    {
        return !is_null($this->parent_id);
    }

    /**
     * Get the parent comment if this is a reply.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Get all replies to this comment.
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     * Get the user who wrote the comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
