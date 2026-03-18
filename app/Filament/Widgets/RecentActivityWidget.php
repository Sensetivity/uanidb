<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ActivityLogs\Tables\ActivityLogsTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Spatie\Activitylog\Models\Activity;

class RecentActivityWidget extends TableWidget
{
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'Останні дії';
    protected static ?int $sort = 10;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Activity::query()
                    ->with('causer')
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('causer.name')
                    ->label('Користувач')
                    ->placeholder('Система'),
                TextColumn::make('event')
                    ->label('Подія')
                    ->badge()
                    ->color(fn (?string $state): string => ActivityLogsTable::eventColor($state)),
                TextColumn::make('subject_type')
                    ->label('Модель')
                    ->formatStateUsing(fn (?string $state): string => ActivityLogsTable::formatSubjectType($state)),
                TextColumn::make('description')
                    ->label('Опис')
                    ->limit(40)
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Коли')
                    ->since(),
            ])
            ->filters([
                SelectFilter::make('event')
                    ->label('Подія')
                    ->options([
                        'created' => 'Створено',
                        'updated' => 'Оновлено',
                        'deleted' => 'Видалено',
                    ]),
            ])
            ->paginated(false);
    }
}
