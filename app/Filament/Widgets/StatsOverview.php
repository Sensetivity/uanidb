<?php

namespace App\Filament\Widgets;

use App\Models\Anime;
use App\Models\Character;
use App\Models\Episode;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Anime', Anime::query()->count()),
            Stat::make('Total Episodes', Episode::query()->count()),
            Stat::make('Total Characters', Character::query()->count()),
            Stat::make('Total Users', User::query()->count()),
        ];
    }
}
