<?php

namespace App\Filament\Widgets;

use App\Models\Anime;
use App\Models\Episode;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TranslationProgress extends StatsOverviewWidget
{
    protected ?string $pollingInterval = null;
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $totalAnime = Anime::query()->count();
        $translatedAnime = Anime::query()
            ->whereNotNull('synopsis_uk')
            ->where('synopsis_uk', '!=', '')
            ->count();
        $animePercent = $totalAnime > 0 ? round($translatedAnime / $totalAnime * 100) : 0;

        $totalEpisodes = Episode::query()->count();
        $translatedEpisodes = Episode::query()
            ->where(function ($q): void {
                $q->where(function ($sub): void {
                    $sub->whereNotNull('title_uk')->where('title_uk', '!=', '');
                })->orWhere(function ($sub): void {
                    $sub->whereNotNull('synopsis_uk')->where('synopsis_uk', '!=', '');
                });
            })
            ->count();
        $episodePercent = $totalEpisodes > 0 ? round($translatedEpisodes / $totalEpisodes * 100) : 0;

        return [
            Stat::make('Аніме перекладено', "{$translatedAnime} / {$totalAnime}")
                ->description("{$animePercent}% завершено"),
            Stat::make('Епізоди перекладено', "{$translatedEpisodes} / {$totalEpisodes}")
                ->description("{$episodePercent}% завершено"),
        ];
    }
}
