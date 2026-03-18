<?php

namespace App\Filament\Resources\Themes\RelationManagers;

use App\Models\Anime;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AnimesRelationManager extends RelationManager
{
    protected static string $relationship = 'animes';
    protected static ?string $title = 'Аніме';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('media'))
            ->recordTitleAttribute('title')
            ->columns([
                ImageColumn::make('poster')
                    ->label('')
                    ->state(fn (Anime $record): ?string => $record->poster_url)
                    ->height(80)
                    ->width(56),
                TextColumn::make('title')
                    ->label('Назва')
                    ->searchable()
                    ->weight(FontWeight::Bold)
                    ->limit(50),
                TextColumn::make('type')
                    ->label('Тип')
                    ->badge(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge(),
            ])
            ->filters([])
            ->headerActions([
                AttachAction::make()->preloadRecordSelect(),
            ])
            ->recordActions([
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
