<?php

namespace App\Filament\Widgets;

use App\Models\Anime;
use App\Models\Episode;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TranslationProgress extends StatsOverviewWidget
{
    protected ?string $pollingInterval = null;

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
            Stat::make('Anime Translated', "{$translatedAnime} / {$totalAnime}")
                ->description("{$animePercent}% completed"),
            Stat::make('Episodes Translated', "{$translatedEpisodes} / {$totalEpisodes}")
                ->description("{$episodePercent}% completed"),
        ];
    }
}
