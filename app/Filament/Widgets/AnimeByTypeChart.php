<?php

namespace App\Filament\Widgets;

use App\Enums\AnimeTypeEnum;
use App\Models\Anime;
use Filament\Widgets\ChartWidget;

class AnimeByTypeChart extends ChartWidget
{
    protected ?string $heading = 'Аніме за типом';
    protected ?string $maxHeight = '300px';
    protected ?string $pollingInterval = null;
    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $data = [];
        $labels = [];
        $colors = [
            '#f59e0b', // amber
            '#3b82f6', // blue
            '#10b981', // emerald
            '#8b5cf6', // violet
            '#ef4444', // red
            '#6b7280', // gray
        ];

        foreach (AnimeTypeEnum::cases() as $type) {
            $count = Anime::query()->where('type', $type)->count();
            if ($count > 0) {
                $labels[] = $type->getLabel();
                $data[] = $count;
            }
        }

        return [
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => array_slice($colors, 0, count($data)),
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
