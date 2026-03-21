<?php

namespace App\Models;

use App\Enums\WatchlistStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $anime_id
 * @property WatchlistStatusEnum $status
 * @property int|null $score
 * @property int|null $episode_progress
 * @property bool $is_private
 * @property \Carbon\Carbon|null $started_at
 * @property \Carbon\Carbon|null $completed_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 */
class UserAnimeList extends BaseModel
{
    /** @use HasFactory<\Database\Factories\UserAnimeListFactory> */
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
     *
     * @return BelongsTo<Anime, $this>
     */
    public function anime(): BelongsTo
    {
        return $this->belongsTo(Anime::class);
    }

    /**
     * Get the user that owns the list item.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
