<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Person extends BaseModel implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use Sluggable;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'people';

    /**
     * Get anime where this person has a role (director, animator, etc).
     */
    public function animes(): BelongsToMany
    {
        return $this->belongsToMany(Anime::class, 'anime_person')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Get anime where this person is a director.
     */
    public function directedAnimes()
    {
        return $this->animes()->wherePivot('role', 'Director');
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
     * Get reviews for this person.
     */
    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable');
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
                'source' => 'name',
                'onUpdate' => false,
            ]
        ];
    }

    /**
     * Get characters this person has voiced.
     */
    public function voicedCharacters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class, 'character_voice', 'person_id', 'character_id')
            ->withPivot('anime_id', 'language')
            ->withTimestamps();
    }
}
