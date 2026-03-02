<?php

namespace App\Models;

use App\Enums\SeasonOfYearEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Season extends BaseModel
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'season_of_year' => SeasonOfYearEnum::class,
            'is_current' => 'boolean',
        ];
    }

    public function animes(): BelongsToMany
    {
        return $this->belongsToMany(Anime::class, 'anime_season')
            ->withPivot('part')
            ->withTimestamps();
    }
}
