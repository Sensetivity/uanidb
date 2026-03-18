<?php

namespace App\Filament\Resources\People\RelationManagers;

use App\Models\Character;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VoicedCharactersRelationManager extends RelationManager
{
    protected static string $relationship = 'voicedCharacters';
    protected static ?string $title = 'Озвучені персонажі';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('media'))
            ->recordTitleAttribute('name')
            ->columns([
                ImageColumn::make('image')
                    ->label('')
                    ->state(fn (Character $record): ?string => $record->image_display_url)
                    ->height(60)
                    ->width(45),
                TextColumn::make('name')
                    ->label("Ім'я")
                    ->searchable()
                    ->weight(FontWeight::Bold),
                TextColumn::make('pivot.language')
                    ->label('Мова')
                    ->badge()
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'japanese' => 'danger',
                        'english' => 'info',
                        'korean' => 'success',
                        default => 'gray',
                    }),
            ])
            ->filters([])
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
