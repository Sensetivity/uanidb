<?php

namespace App\Filament\Resources\Animes\Schemas;

use App\Enums\AnimeStatusEnum;
use App\Enums\AnimeTypeEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
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
                            ->label('Назва')
                            ->required()
                            ->maxLength(255),
                    ]),
                Grid::make(2)
                    ->schema([
                        Select::make('type')
                            ->label('Тип')
                            ->options(AnimeTypeEnum::class)
                            ->required(),
                        Select::make('status')
                            ->label('Статус')
                            ->options(AnimeStatusEnum::class)
                            ->required(),
                    ]),
                Grid::make(2)
                    ->schema([
                        DatePicker::make('aired_from')
                            ->label('Початок показу'),
                        DatePicker::make('aired_to')
                            ->label('Кінець показу'),
                    ]),
                Grid::make(3)
                    ->schema([
                        TextInput::make('score')
                            ->label('Оцінка')
                            ->numeric()
                            ->step(0.01)
                            ->readOnly(),
                        TextInput::make('rank')
                            ->label('Рейтинг')
                            ->numeric()
                            ->readOnly(),
                        TextInput::make('popularity')
                            ->label('Популярність')
                            ->numeric()
                            ->step(0.01)
                            ->readOnly(),
                    ]),
                Textarea::make('synopsis')
                    ->label('Опис')
                    ->rows(5)
                    ->columnSpanFull(),
                Textarea::make('synopsis_uk')
                    ->label('Опис (українською)')
                    ->rows(5)
                    ->columnSpanFull(),
                TextInput::make('source_image_url')
                    ->label('URL джерела зображення')
                    ->url()
                    ->maxLength(500)
                    ->columnSpanFull(),
                Section::make('Постер')
                    ->schema([
                        FileUpload::make('main_poster_upload')
                            ->label('Головний постер')
                            ->image()
                            ->imageEditor()
                            ->directory('anime-posters')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->columnSpanFull()
                            ->dehydrated(false),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull(),
                Select::make('genres')
                    ->label('Жанри')
                    ->multiple()
                    ->relationship('genres', 'name')
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),
                Select::make('themes')
                    ->label('Теми')
                    ->multiple()
                    ->relationship('themes', 'name')
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),
            ]);
    }
}
