<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Studio extends BaseModel
{
    use HasFactory;
    use LogsActivity;
    use Sluggable;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
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
}
