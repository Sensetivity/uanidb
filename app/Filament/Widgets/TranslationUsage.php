<?php

namespace App\Filament\Widgets;

use App\Services\Translation\TranslationService;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TranslationUsage extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $usage = app(TranslationService::class)->getUsage();

        $percent = round($usage->characterCount / max($usage->characterLimit, 1) * 100, 1);

        $color = match (true) {
            $percent >= 90 => 'danger',
            $percent >= 70 => 'warning',
            default => 'success',
        };

        return [
            Stat::make('Translation Usage', number_format($usage->characterCount) . ' / ' . number_format($usage->characterLimit))
                ->description($percent . '% used')
                ->color($color),
        ];
    }
}
