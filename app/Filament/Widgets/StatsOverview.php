<?php

namespace App\Filament\Widgets;

use App\Models\Anime;
use App\Models\Character;
use App\Models\Episode;
use App\Models\Person;
use App\Models\Studio;
use App\Models\User;
use Carbon\Carbon;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class StatsOverview extends StatsOverviewWidget
{
    protected ?string $pollingInterval = null;
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $weekAgo = Carbon::now()->subWeek();

        $animeCount = Cache::remember('stats.anime_count', 300, fn () => Anime::query()->count());
        $animeWeek = Cache::remember('stats.anime_week', 300, fn () => Anime::query()->where('created_at', '>=', $weekAgo)->count());

        $episodeCount = Cache::remember('stats.episode_count', 300, fn () => Episode::query()->count());
        $episodeWeek = Cache::remember('stats.episode_week', 300, fn () => Episode::query()->where('created_at', '>=', $weekAgo)->count());

        $characterCount = Cache::remember('stats.character_count', 300, fn () => Character::query()->count());
        $characterWeek = Cache::remember('stats.character_week', 300, fn () => Character::query()->where('created_at', '>=', $weekAgo)->count());

        $personCount = Cache::remember('stats.person_count', 300, fn () => Person::query()->count());
        $studioCount = Cache::remember('stats.studio_count', 300, fn () => Studio::query()->count());
        $userCount = Cache::remember('stats.user_count', 300, fn () => User::query()->count());

        return [
            Stat::make('Аніме', $animeCount)
                ->description("+{$animeWeek} за тиждень")
                ->descriptionIcon(Heroicon::ArrowTrendingUp)
                ->color('primary'),
            Stat::make('Епізоди', $episodeCount)
                ->description("+{$episodeWeek} за тиждень")
                ->descriptionIcon(Heroicon::ArrowTrendingUp)
                ->color('success'),
            Stat::make('Персонажі', $characterCount)
                ->description("+{$characterWeek} за тиждень")
                ->descriptionIcon(Heroicon::ArrowTrendingUp)
                ->color('info'),
            Stat::make('Люди', $personCount),
            Stat::make('Студії', $studioCount),
            Stat::make('Користувачі', $userCount),
        ];
    }
}
