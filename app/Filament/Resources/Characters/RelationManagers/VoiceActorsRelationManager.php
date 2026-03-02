<?php

namespace App\Filament\Resources\Characters\RelationManagers;

use App\Models\Anime;
use App\Models\Person;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VoiceActorsRelationManager extends RelationManager
{
    protected static string $relationship = 'voiceActors';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('anime_id')
                    ->label('Anime')
                    ->options(Anime::query()->pluck('title', 'id'))
                    ->searchable()
                    ->required(),
                TextInput::make('language')
                    ->required()
                    ->maxLength(10),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('pivot.language')
                    ->label('Language')
                    ->badge(),
                TextColumn::make('anime_title')
                    ->label('Anime')
                    ->state(function (Person $record): string {
                        $animeId = $record->pivot->anime_id;

                        return Anime::query()->find($animeId)?->title ?? '—';
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->schema(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Select::make('anime_id')
                            ->label('Anime')
                            ->options(Anime::query()->pluck('title', 'id'))
                            ->searchable()
                            ->required(),
                        TextInput::make('language')
                            ->required()
                            ->maxLength(10),
                    ]),
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
