<?php

namespace App\Models;

use App\Models\Builders\StudioBuilder;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property int $id
 * @property int|null $mal_id
 * @property string $name
 * @property string $slug
 * @property string|null $about
 * @property string|null $source_logo_url
 * @property string|null $website
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read string|null $logo_display_url
 *
 * @method static StudioBuilder query()
 */
class Studio extends BaseModel implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
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

    public function newEloquentBuilder($query): StudioBuilder
    {
        return new StudioBuilder($query);
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
     * Register media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile();
    }

    /**
     * Register media conversions for image processing.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumbnail')
            ->width(100)
            ->height(100)
            ->sharpen(10)
            ->nonQueued(); // @phpstan-ignore method.notFound
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
     * Get the display logo URL, preferring media library over source_logo_url.
     */
    protected function logoDisplayUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => $this->getFirstMediaUrl('logo') ?: $this->source_logo_url);
    }
}
