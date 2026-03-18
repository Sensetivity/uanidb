<?php

namespace App\Models;

use App\Enums\SeasonOfYearEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Season extends BaseModel
{
    use HasFactory;
    use LogsActivity;

    public function animes(): BelongsToMany
    {
        return $this->belongsToMany(Anime::class, 'anime_season')
            ->withPivot('part')
            ->withTimestamps();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }

    protected function casts(): array
    {
        return [
            'season_of_year' => SeasonOfYearEnum::class,
            'is_current' => 'boolean',
        ];
    }

    protected function name(): Attribute
    {
        return Attribute::get(fn (): string => $this->season_of_year->getLabel() . ' ' . $this->year);
    }
}
