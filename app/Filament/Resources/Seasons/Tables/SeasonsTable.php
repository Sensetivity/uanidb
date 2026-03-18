<?php

namespace App\Filament\Resources\Seasons\Tables;

use App\Enums\SeasonOfYearEnum;
use App\Models\Season;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class SeasonsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Назва')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('year')
                    ->label('Рік')
                    ->sortable(),
                TextColumn::make('season_of_year')
                    ->label('Пора року')
                    ->badge()
                    ->sortable(),
                IconColumn::make('is_current')
                    ->label('Поточний')
                    ->boolean(),
                TextColumn::make('deleted_at')
                    ->label('Стан')
                    ->badge()
                    ->formatStateUsing(fn ($state): ?string => $state ? 'Видалено' : null)
                    ->color('danger')
                    ->placeholder('')
                    ->toggleable()
                    ->sortable(),
            ])
            ->defaultSort('year', 'desc')
            ->filters([
                SelectFilter::make('year')
                    ->label('Рік')
                    ->options(
                        fn () => Season::query()
                        ->select('year')
                        ->distinct()
                        ->orderByDesc('year')
                        ->pluck('year', 'year')
                        ->toArray()
                    ),
                SelectFilter::make('season_of_year')
                    ->label('Пора року')
                    ->options(SeasonOfYearEnum::class),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
