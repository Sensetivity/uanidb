<?php

namespace App\Models;

use App\Enums\AnimeRatingEnum;
use App\Enums\AnimeRelationEnum;
use App\Enums\AnimeStatusEnum;
use App\Enums\AnimeTypeEnum;
use App\Enums\CharacterRoleEnum;
use App\Enums\SourceTypeEnum;
use App\Models\Builders\AnimeBuilder;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Class Anime
 *
 * @package App\Models
 *
 * @property int $id
 * @property int $mal_id MyAnimeList ID
 * @property int|null $anidb_id AniDB ID
 * @property string $title Main title
 * @property string $slug URL friendly title
 * @property string|null $synopsis English synopsis
 * @property string|null $synopsis_uk Ukrainian synopsis
 * @property AnimeTypeEnum $type Anime type (TV, Movie, OVA, etc.)
 * @property int|null $episode_count Number of episodes
 * @property AnimeStatusEnum $status Airing status
 * @property Carbon|null $aired_from Start airing date
 * @property Carbon|null $aired_to End airing date
 * @property bool|null $aired_unknown Whether airing date is unknown
 * @property string|null $aired_string String representation of airing dates
 * @property string|null $broadcast Broadcast day and time
 * @property SourceTypeEnum|null $source_type Source material type
 * @property int|null $duration Duration in minutes
 * @property AnimeRatingEnum|null $rating Age rating
 * @property float|null $score Average user score
 * @property int|null $rank Popularity rank
 * @property float|null $popularity Popularity score
 * @property string|null $source_image_url Original image URL from API
 * @property Carbon|null $last_synced_at When last successfully synced from API
 * @property float $sync_priority Cached priority score for sync ordering
 * @property int $failed_sync_count Consecutive sync failures for backoff
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read Collection|AnimeTitle[] $titles All titles in different languages
 * @property-read Collection|Episode[] $episodes All episodes
 * @property-read Collection|Season[] $seasons Seasons the anime belongs to
 * @property-read Collection|Genre[] $genres Genres associated with this anime
 * @property-read Collection|Theme[] $themes Themes associated with this anime
 * @property-read Collection|Character[] $characters Characters in this anime
 * @property-read Collection|Character[] $mainCharacters Main characters in this anime
 * @property-read Collection|Character[] $supportingCharacters Supporting characters in this anime
 * @property-read Collection|Studio[] $studios Studios that produced this anime
 * @property-read Studio|null $mainStudio Main studio that produced this anime
 * @property-read Collection|Studio[] $producers Producers of this anime
 * @property-read Collection|Studio[] $licensors Licensors of this anime
 * @property-read Collection|Person[] $people People associated with this anime
 * @property-read Collection|Anime[] $relatedAnime Related anime series
 * @property-read Collection|Anime[] $sequels Sequel anime series
 * @property-read Collection|Anime[] $prequels Prequel anime series
 * @property-read Collection|PromotionVideo[] $promotionVideos Promotional videos
 * @property-read Collection|UserAnimeList[] $userLists Users who have this anime in their lists
 * @property-read Collection|Review[] $reviews Reviews of this anime
 * @property-read Collection|Comment[] $comments Comments on this anime
 * @property-read string|null $poster_url Display poster URL
 * @property-read MediaCollection $media All media
 *
 * @method static AnimeBuilder query()
 */
class Anime extends BaseModel implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use LogsActivity;
    use Sluggable;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'aired_from' => 'date',
        'aired_to' => 'date',
        'aired_unknown' => 'boolean',
        'type' => AnimeTypeEnum::class,
        'episode_count' => 'integer',
        'status' => AnimeStatusEnum::class,
        'source_type' => SourceTypeEnum::class,
        'duration' => 'integer',
        'rating' => AnimeRatingEnum::class,
        'score' => 'float',
        'rank' => 'integer',
        'popularity' => 'float',
        'last_synced_at' => 'datetime',
        'sync_priority' => 'float',
        'failed_sync_count' => 'integer',
    ];

    /**
     * Get all characters associated with this anime.
     */
    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class, 'anime_character')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Get comments for this anime.
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get all episodes for this anime.
     */
    public function episodes(): HasMany
    {
        return $this->hasMany(Episode::class)->orderBy('number');
    }

    /**
     * Get all external links for this anime.
     */
    public function externalLinks(): HasMany
    {
        return $this->hasMany(AnimeExternalLink::class);
    }

    /**
     * Get all genres associated with this anime.
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'anime_genre')
            ->withTimestamps();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }

    /**
     * Get all licensors for this anime.
     */
    public function licensors(): BelongsToMany
    {
        return $this->belongsToMany(Studio::class, 'anime_licensor')
            ->withPivot('region')
            ->withTimestamps();
    }

    /**
     * Get main characters for this anime.
     */
    public function mainCharacters(): BelongsToMany
    {
        return $this->characters()->wherePivot('role', CharacterRoleEnum::Main);
    }

    /**
     * Get main studio for this anime.
     *
     * @return Studio|null
     */
    public function mainStudio(): ?Studio
    {
        /** @var Studio|null */
        return $this->studios()->wherePivot('is_main', true)->first();
    }

    /**
     * Mark this anime as successfully synced.
     */
    public function markAsSynced(): void
    {
        $this->update(['last_synced_at' => now(), 'failed_sync_count' => 0]);
    }

    /**
     * Increment the failed sync counter.
     */
    public function markSyncFailed(): void
    {
        $this->increment('failed_sync_count');
    }

    public function newEloquentBuilder($query): AnimeBuilder
    {
        return new AnimeBuilder($query);
    }

    /**
     * Get all people associated with this anime (directors, etc).
     */
    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'anime_person')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Get prequels for this anime.
     */
    public function prequels(): BelongsToMany
    {
        return $this->relatedAnime()->wherePivot('relation_type', AnimeRelationEnum::PREQUEL);
    }

    /**
     * Get all producers for this anime.
     */
    public function producers(): BelongsToMany
    {
        return $this->belongsToMany(Studio::class, 'anime_producer')
            ->withPivot('role', 'is_main', 'order', 'notes')
            ->withTimestamps();
    }

    /**
     * Get all promotional videos for this anime.
     */
    public function promotionVideos(): HasMany
    {
        return $this->hasMany(PromotionVideo::class);
    }

    /**
     * Register media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main_poster')
            ->singleFile();

        $this->addMediaCollection('posters');

        $this->addMediaCollection('screenshots');
    }

    /**
     * Register media conversions for image processing.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(100)
            ->height(140)
            ->sharpen(10)
            ->nonQueued(); // @phpstan-ignore method.notFound

        $this->addMediaConversion('medium')
            ->width(225)
            ->height(350)
            ->sharpen(10)
            ->nonQueued(); // @phpstan-ignore method.notFound

        $this->addMediaConversion('large')
            ->width(450)
            ->height(700)
            ->sharpen(10)
            ->nonQueued(); // @phpstan-ignore method.notFound
    }

    /**
     * Get all related anime.
     */
    public function relatedAnime(): BelongsToMany
    {
        return $this->belongsToMany(Anime::class, 'related_anime', 'anime_id', 'related_anime_id')
            ->withPivot('relation_type')
            ->withTimestamps();
    }

    /**
     * Get reviews for this anime.
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    /**
     * Get the seasons for this anime.
     */
    public function seasons(): BelongsToMany
    {
        return $this->belongsToMany(Season::class, 'anime_season')
            ->withPivot('part')
            ->withTimestamps();
    }

    /**
     * Get sequels for this anime.
     */
    public function sequels(): BelongsToMany
    {
        return $this->relatedAnime()->wherePivot('relation_type', AnimeRelationEnum::SEQUEL);
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
                'source' => 'title',
                'onUpdate' => false,
            ]
        ];
    }

    /**
     * Get all studios for this anime.
     */
    public function studios(): BelongsToMany
    {
        return $this->belongsToMany(Studio::class, 'anime_studio')
            ->withPivot('role', 'is_main', 'order', 'notes')
            ->withTimestamps();
    }

    /**
     * Get supporting characters for this anime.
     */
    public function supportingCharacters(): BelongsToMany
    {
        return $this->characters()->wherePivot('role', CharacterRoleEnum::Supporting);
    }

    /**
     * Get all themes associated with this anime.
     */
    public function themes(): BelongsToMany
    {
        return $this->belongsToMany(Theme::class, 'anime_theme')
            ->withTimestamps();
    }

    /**
     * Get all titles for this anime.
     */
    public function titles(): HasMany
    {
        return $this->hasMany(AnimeTitle::class);
    }

    /**
     * Get all users who have this anime in their list.
     */
    public function userLists(): HasMany
    {
        return $this->hasMany(UserAnimeList::class);
    }

    /**
     * Get the poster URL, preferring media library over image_url.
     */
    protected function posterUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => $this->getFirstMediaUrl('main_poster') ?: $this->source_image_url);
    }
}
