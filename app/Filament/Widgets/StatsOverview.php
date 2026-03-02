<?php

namespace App\Filament\Widgets;

use App\Models\Anime;
use App\Models\Character;
use App\Models\Episode;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class StatsOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Anime', Cache::remember('stats.anime_count', 300, fn () => Anime::query()->count())),
            Stat::make('Total Episodes', Cache::remember('stats.episode_count', 300, fn () => Episode::query()->count())),
            Stat::make('Total Characters', Cache::remember('stats.character_count', 300, fn () => Character::query()->count())),
            Stat::make('Total Users', Cache::remember('stats.user_count', 300, fn () => User::query()->count())),
        ];
    }
}
