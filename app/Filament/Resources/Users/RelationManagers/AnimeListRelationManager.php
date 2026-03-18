<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AnimeListRelationManager extends RelationManager
{
    protected static string $relationship = 'animeList';
    protected static ?string $title = 'Список аніме';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('anime.title')
            ->columns([
                TextColumn::make('anime.title')
                    ->label('Аніме')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge(),
                TextColumn::make('score')
                    ->label('Оцінка')
                    ->placeholder('—'),
                TextColumn::make('episode_progress')
                    ->label('Прогрес'),
                TextColumn::make('started_at')
                    ->label('Початок')
                    ->date()
                    ->placeholder('—'),
                TextColumn::make('completed_at')
                    ->label('Завершено')
                    ->date()
                    ->placeholder('—'),
            ])
            ->filters([])
            ->recordActions([
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
