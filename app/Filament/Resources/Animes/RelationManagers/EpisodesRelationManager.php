<?php

namespace App\Filament\Resources\Animes\RelationManagers;

use App\Enums\EpisodeTypeEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EpisodesRelationManager extends RelationManager
{
    protected static string $relationship = 'episodes';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('number')
                    ->numeric()
                    ->required(),
                Select::make('type')
                    ->options(EpisodeTypeEnum::class)
                    ->required(),
                TextInput::make('title')
                    ->label('Title (Romaji)')
                    ->maxLength(255),
                TextInput::make('title_en')
                    ->label('Title (EN)')
                    ->maxLength(255),
                TextInput::make('title_uk')
                    ->label('Title (UK)')
                    ->maxLength(255),
                DatePicker::make('aired'),
                TextInput::make('duration')
                    ->numeric()
                    ->suffix('min'),
                Textarea::make('synopsis')
                    ->rows(3)
                    ->columnSpanFull(),
                Textarea::make('synopsis_uk')
                    ->label('Synopsis (Ukrainian)')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('number')
            ->defaultSort('number')
            ->columns([
                TextColumn::make('number')
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Title (Romaji)')
                    ->limit(40),
                TextColumn::make('title_uk')
                    ->label('Title (UK)')
                    ->limit(40)
                    ->toggleable(),
                TextColumn::make('aired')
                    ->date()
                    ->sortable(),
                TextColumn::make('type')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
