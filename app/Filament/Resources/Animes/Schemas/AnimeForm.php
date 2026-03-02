<?php

namespace App\Filament\Resources\Animes\Schemas;

use App\Enums\AnimeStatusEnum;
use App\Enums\AnimeTypeEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class AnimeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)
                    ->schema([
                        TextInput::make('mal_id')
                            ->label('MAL ID')
                            ->numeric()
                            ->required(),
                        TextInput::make('anidb_id')
                            ->label('AniDB ID')
                            ->numeric()
                            ->readOnly(),
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                    ]),
                Grid::make(2)
                    ->schema([
                        Select::make('type')
                            ->options(AnimeTypeEnum::class)
                            ->required(),
                        Select::make('status')
                            ->options(AnimeStatusEnum::class)
                            ->required(),
                    ]),
                Grid::make(2)
                    ->schema([
                        DatePicker::make('aired_from'),
                        DatePicker::make('aired_to'),
                    ]),
                Grid::make(3)
                    ->schema([
                        TextInput::make('score')
                            ->numeric()
                            ->step(0.01)
                            ->readOnly(),
                        TextInput::make('rank')
                            ->numeric()
                            ->readOnly(),
                        TextInput::make('popularity')
                            ->numeric()
                            ->step(0.01)
                            ->readOnly(),
                    ]),
                Textarea::make('synopsis')
                    ->rows(5)
                    ->columnSpanFull(),
                Textarea::make('synopsis_uk')
                    ->label('Synopsis (Ukrainian)')
                    ->rows(5)
                    ->columnSpanFull(),
                TextInput::make('image_url')
                    ->label('Image URL')
                    ->url()
                    ->maxLength(500)
                    ->columnSpanFull(),
                Select::make('genres')
                    ->multiple()
                    ->relationship('genres', 'name')
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),
                Select::make('themes')
                    ->multiple()
                    ->relationship('themes', 'name')
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),
            ]);
    }
}
