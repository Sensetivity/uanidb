<?php

namespace App\Models;

use App\Enums\EpisodeTypeEnum;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class Episode
 *
 * @package App\Models
 *
 * @property int $id
 * @property int $anime_id Foreign key to anime table
 * @property int|null $mal_id MyAnimeList ID
 * @property EpisodeTypeEnum $type Episode type (1-Regular, 2-Compilation, 3-Filler)
 * @property int $number Episode number
 * @property string $title Episode title
 * @property string $slug URL-friendly slug
 * @property string|null $title_en English title
 * @property string|null $title_uk Ukrainian title
 * @property string|null $title_ja Japanese title
 * @property string|null $synopsis English synopsis
 * @property string|null $synopsis_uk Ukrainian synopsis
 * @property string|null $aired_string String representation of air date
 * @property Carbon|null $aired Air date
 * @property bool $aired_unknown Whether air date is unknown
 * @property int|null $duration Duration in minutes
 * @property float|null $rating Episode rating
 * @property int|null $status Episode status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read Anime $anime The anime this episode belongs to
 * @property-read Collection|Comment[] $comments Comments on this episode
 */
class Episode extends BaseModel
{
    use HasFactory;
    use Sluggable;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'anime_id' => 'integer',
        'mal_id' => 'integer',
        'aired' => 'date',
        'aired_unknown' => 'boolean',
        'type' => EpisodeTypeEnum::class,
        'number' => 'integer',
        'duration' => 'integer',
        'rating' => 'float',
        'status' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * Get the anime that owns the episode.
     *
     * @return BelongsTo
     */
    public function anime(): BelongsTo
    {
        return $this->belongsTo(Anime::class);
    }

    /**
     * Get comments for this episode.
     *
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Check if the episode is aired.
     *
     * @return bool
     */
    public function isAired(): bool
    {
        if ($this->aired_unknown) {
            return false;
        }

        return $this->aired && $this->aired->isPast();
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['number', 'title'],
                'onUpdate' => false,
            ]
        ];
    }
}
