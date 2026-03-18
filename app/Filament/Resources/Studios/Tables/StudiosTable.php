<?php

namespace App\Filament\Resources\Studios\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class StudiosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Назва')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->label('Слаг')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('mal_id')
                    ->label('MAL ID')
                    ->sortable(),
                TextColumn::make('website')
                    ->label('Вебсайт')
                    ->toggleable(),
                TextColumn::make('deleted_at')
                    ->label('Стан')
                    ->badge()
                    ->formatStateUsing(fn ($state): ?string => $state ? 'Видалено' : null)
                    ->color('danger')
                    ->placeholder('')
                    ->toggleable()
                    ->sortable(),
            ])
            ->defaultSort('name')
            ->filters([
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
