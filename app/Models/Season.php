<?php

namespace App\Models;

use App\Enums\SeasonOfYearEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @property int $id
 * @property int $year
 * @property SeasonOfYearEnum $season_of_year
 * @property string|null $start_date
 * @property string|null $end_date
 * @property bool $is_current
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property-read string $name
 */
class Season extends BaseModel
{
    /** @use HasFactory<\Database\Factories\SeasonFactory> */
    use HasFactory;

    use LogsActivity;

    /** @return BelongsToMany<Anime, $this> */
    public function animes(): BelongsToMany
    {
        return $this->belongsToMany(Anime::class, 'anime_season')
            ->withPivot('part')
            ->withTimestamps();
    }

    public static function findByYearAndSlug(string $year, string $seasonSlug): ?self
    {
        $seasonEnum = SeasonOfYearEnum::fromString($seasonSlug);

        return $seasonEnum
            ? static::query()->where('year', $year)->where('season_of_year', $seasonEnum)->first()
            : null;
    }

    public static function findCurrentOrLatest(): ?self
    {
        return static::query()->where('is_current', true)->first()
            ?? static::query()->orderByDesc('year')->orderByDesc('season_of_year')->first();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'season_of_year' => SeasonOfYearEnum::class,
            'is_current' => 'boolean',
        ];
    }

    /** @return Attribute<string, never> */
    protected function name(): Attribute
    {
        return Attribute::get(fn (): string => $this->season_of_year->getLabel() . ' ' . $this->year);
    }
}
