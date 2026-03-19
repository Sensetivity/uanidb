<?php

namespace App\Models;

use App\Enums\WatchlistStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAnimeList extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'started_at' => 'date',
        'completed_at' => 'date',
        'is_private' => 'boolean',
        'episode_progress' => 'integer',
        'score' => 'integer',
        'status' => WatchlistStatusEnum::class,
    ];

    /**
     * Get the anime associated with the list item.
     */
    public function anime(): BelongsTo
    {
        return $this->belongsTo(Anime::class);
    }

    /**
     * Get the user that owns the list item.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
