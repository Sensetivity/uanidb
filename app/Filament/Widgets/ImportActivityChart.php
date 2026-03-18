<?php

namespace App\Filament\Widgets;

use App\Models\Anime;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;

class ImportActivityChart extends ChartWidget
{
    protected ?string $heading = 'Імпорт аніме (останні 6 місяців)';
    protected ?string $maxHeight = '300px';
    protected ?string $pollingInterval = null;
    protected static ?int $sort = 5;

    protected function getData(): array
    {
        $start = Carbon::now()->subMonths(6)->startOfWeek();
        $end = Carbon::now()->endOfWeek();

        $animes = Anime::query()
            ->where('created_at', '>=', $start)
            ->get(['created_at']);

        $weekCounts = [];
        foreach ($animes as $anime) {
            $key = $anime->created_at->startOfWeek()->format('Y-W');
            $weekCounts[$key] = ($weekCounts[$key] ?? 0) + 1;
        }

        $labels = [];
        $data = [];

        foreach (CarbonPeriod::create($start, '1 week', $end) as $week) {
            $key = $week->format('Y-W');
            $labels[] = $week->format('d.m');
            $data[] = $weekCounts[$key] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Нове аніме',
                    'data' => $data,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
