<?php

namespace App\Services\AnimeImport\Processors;

use App\Dto\AnimeFullDto;
use App\Enums\SeasonOfYearEnum;
use App\Models\Anime;
use App\Models\Season;

class SeasonProcessor implements RelationProcessor
{
    public function sync(Anime $anime, AnimeFullDto $dto): void
    {
        $seasonString = $dto->anime->season;
        $year         = $dto->anime->year;

        if (! $seasonString || ! $year) {
            return;
        }

        $seasonEnum = SeasonOfYearEnum::fromString($seasonString);

        if (! $seasonEnum) {
            return;
        }

        $season = Season::query()->firstOrCreate(
            ['year' => $year, 'season_of_year' => $seasonEnum],
            [
                'name'       => "{$seasonEnum->name} {$year}",
                'start_date' => $this->startDate($seasonEnum, $year),
                'end_date'   => $this->endDate($seasonEnum, $year),
                'is_current' => false,
            ],
        );

        $anime->seasons()->syncWithoutDetaching([$season->id]);
    }

    public function clear(Anime $anime): void
    {
        $anime->seasons()->detach();
    }

    private function startDate(SeasonOfYearEnum $season, int $year): string
    {
        return match ($season) {
            SeasonOfYearEnum::Winter => "{$year}-01-01",
            SeasonOfYearEnum::Spring => "{$year}-04-01",
            SeasonOfYearEnum::Summer => "{$year}-07-01",
            SeasonOfYearEnum::Fall   => "{$year}-10-01",
        };
    }

    private function endDate(SeasonOfYearEnum $season, int $year): string
    {
        return match ($season) {
            SeasonOfYearEnum::Winter => "{$year}-03-31",
            SeasonOfYearEnum::Spring => "{$year}-06-30",
            SeasonOfYearEnum::Summer => "{$year}-09-30",
            SeasonOfYearEnum::Fall   => "{$year}-12-31",
        };
    }
}
