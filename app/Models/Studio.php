<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Cviebrock\EloquentSluggable\Sluggable;

class Studio extends BaseModel
{
    use HasFactory, Sluggable;

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
     * Get animes where this studio is the primary studio.
     */
    public function animes(): BelongsToMany
    {
        return $this->belongsToMany(Anime::class, 'anime_studio')
            ->withPivot('role', 'is_main', 'order', 'notes')
            ->wherePivot('is_main', true)
            ->withTimestamps();
    }

    /**
     * Get animes where this studio is a producer.
     */
    public function producedAnimes(): BelongsToMany
    {
        return $this->belongsToMany(Anime::class, 'anime_producer')
            ->withPivot('role', 'is_main', 'order', 'notes')
            ->withTimestamps();
    }

    /**
     * Get animes where this studio is a licensor.
     */
    public function licensedAnimes(): BelongsToMany
    {
        return $this->belongsToMany(Anime::class, 'anime_licensor')
            ->withPivot('region')
            ->withTimestamps();
    }
}
