<?php

namespace App\Filament\Resources\Episodes\Schemas;

use App\Enums\EpisodeTypeEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EpisodeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('anime_id')
                    ->relationship('anime', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),
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
                TextInput::make('title_ja')
                    ->label('Title (JA)')
                    ->maxLength(255),
                DatePicker::make('aired'),
                TextInput::make('duration')
                    ->numeric()
                    ->suffix('min'),
                Textarea::make('synopsis')
                    ->rows(4)
                    ->columnSpanFull(),
                Textarea::make('synopsis_uk')
                    ->label('Synopsis (Ukrainian)')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}
