<?php

namespace App\Filament\Widgets;

use App\Enums\AnimeStatusEnum;
use App\Models\Anime;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class SyncStatusWidget extends StatsOverviewWidget
{
    private const CACHE_TTL_SECONDS = 300;

    protected ?string $pollingInterval = null;
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $needSync = Cache::remember('stats.sync_need_sync', self::CACHE_TTL_SECONDS, fn () => Anime::query()
            ->where('sync_priority', '>', 0)
            ->count());

        $airingCount = Cache::remember('stats.sync_airing', self::CACHE_TTL_SECONDS, fn () => Anime::query()
            ->where('status', AnimeStatusEnum::AIRING)
            ->count());

        $avgFreshness = Cache::remember('stats.sync_avg_freshness', self::CACHE_TTL_SECONDS, function () {
            $avg = Anime::query()
                ->whereNotNull('last_synced_at')
                ->pluck('last_synced_at')
                ->avg(fn ($date) => $date->diffInDays(now()));

            return $avg !== null ? round((float) $avg, 1) : null;
        });

        $failedCount = Cache::remember('stats.sync_failed', self::CACHE_TTL_SECONDS, fn () => Anime::query()
            ->where('failed_sync_count', '>', 0)
            ->count());

        return [
            Stat::make('Потребують синхронізації', $needSync)
                ->descriptionIcon(Heroicon::ArrowPath)
                ->color('warning'),
            Stat::make('Зараз виходить', $airingCount)
                ->descriptionIcon(Heroicon::OutlinedPlay)
                ->color('success'),
            Stat::make('Середня свіжість', $avgFreshness !== null ? "{$avgFreshness} днів" : '—')
                ->descriptionIcon(Heroicon::OutlinedClock)
                ->color('info'),
            Stat::make('Невдалі синхронізації', $failedCount)
                ->descriptionIcon(Heroicon::ExclamationTriangle)
                ->color($failedCount > 0 ? 'danger' : 'gray'),
        ];
    }
}
