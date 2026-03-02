<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

/**
 * Class Character
 *
 * @package App\Models
 *
 * @property int $id
 * @property int|null $mal_id MyAnimeList ID
 * @property string $name Character's name
 * @property string $slug URL-friendly name
 * @property string|null $japanese_name Character's name in Japanese
 * @property string|null $about Character description/biography
 * @property string|null $image_url URL to the character's image
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read Collection|Anime[] $animes Anime series featuring this character
 * @property-read Collection|Person[] $voiceActors Voice actors for this character
 * @property-read Collection|Review[] $reviews Reviews of this character
 * @property-read MediaCollection $media All media
 */
class Character extends BaseModel implements HasMedia
{
    use HasFactory, Sluggable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'mal_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => false,
            ]
        ];
    }

    /**
     * Register media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main_image')
            ->singleFile();
    }

    /**
     * Get all anime associated with this character.
     *
     * @return BelongsToMany
     */
    public function animes(): BelongsToMany
    {
        return $this->belongsToMany(Anime::class, 'anime_character')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Get the voice actors for this character.
     *
     * @return BelongsToMany
     */
    public function voiceActors(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'character_voice', 'character_id', 'person_id')
            ->withPivot('anime_id', 'language')
            ->withTimestamps();
    }

    /**
     * Get reviews for this character.
     *
     * @return MorphMany
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    /**
     * Get comments for this character.
     *
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
