<?php

namespace App\Filament\Resources\ActivityLogs\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Models\Activity;

class ActivityLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with('causer'))
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('causer.name')
                    ->label('Користувач')
                    ->placeholder('Система')
                    ->sortable(),
                TextColumn::make('subject_type')
                    ->label('Модель')
                    ->formatStateUsing(fn (?string $state): string => self::formatSubjectType($state))
                    ->sortable(),
                TextColumn::make('event')
                    ->label('Подія')
                    ->badge()
                    ->color(fn (?string $state): string => self::eventColor($state)),
                TextColumn::make('description')
                    ->label('Опис')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Дата')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('event')
                    ->label('Подія')
                    ->options(fn (): array => Activity::query()
                        ->distinct()
                        ->whereNotNull('event')
                        ->pluck('event', 'event')
                        ->toArray()),
                SelectFilter::make('subject_type')
                    ->label('Модель')
                    ->options(fn (): array => Activity::query()
                        ->distinct()
                        ->whereNotNull('subject_type')
                        ->pluck('subject_type')
                        ->mapWithKeys(fn (string $type): array => [$type => class_basename($type)])
                        ->toArray()),
            ])
            ->recordActions([
                ViewAction::make()->iconButton(),
            ]);
    }

    public static function eventColor(?string $state): string
    {
        return match ($state) {
            'created' => 'success',
            'updated' => 'warning',
            'deleted' => 'danger',
            default => 'gray',
        };
    }

    public static function formatSubjectType(?string $state): string
    {
        return $state ? class_basename($state) : '—';
    }
}
