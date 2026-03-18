<?php

namespace App\Filament\Resources\ImportLogs\Tables;

use App\Enums\ImportJobTypeEnum;
use App\Enums\ImportStatusEnum;
use App\Filament\Resources\Animes\AnimeResource;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ImportLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with('anime'))
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('job_type')
                    ->label('Тип завдання')
                    ->badge()
                    ->sortable(),
                TextColumn::make('anime.title')
                    ->label('Аніме')
                    ->searchable()
                    ->limit(30)
                    ->url(fn ($record): ?string => $record->anime_id
                        ? AnimeResource::getUrl('view', ['record' => $record->anime_id])
                        : null),
                TextColumn::make('mal_id')
                    ->label('MAL ID')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->sortable(),
                TextColumn::make('started_at')
                    ->label('Початок')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('completed_at')
                    ->label('Завершення')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('error_message')
                    ->label('Помилка')
                    ->limit(40)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options(ImportStatusEnum::class),
                SelectFilter::make('job_type')
                    ->label('Тип завдання')
                    ->options(ImportJobTypeEnum::class),
            ])
            ->recordActions([
                ViewAction::make()->iconButton(),
            ]);
    }
}
