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
                    ->label('Аніме')
                    ->relationship('anime', 'title')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('number')
                    ->label('Номер')
                    ->numeric()
                    ->required(),
                Select::make('type')
                    ->label('Тип')
                    ->options(EpisodeTypeEnum::class)
                    ->required(),
                TextInput::make('title')
                    ->label('Назва (ромадзі)')
                    ->maxLength(255),
                TextInput::make('title_en')
                    ->label('Назва (EN)')
                    ->maxLength(255),
                TextInput::make('title_uk')
                    ->label('Назва (UK)')
                    ->maxLength(255),
                TextInput::make('title_ja')
                    ->label('Назва (JA)')
                    ->maxLength(255),
                DatePicker::make('aired')
                    ->label('Дата виходу'),
                TextInput::make('duration')
                    ->label('Тривалість')
                    ->numeric()
                    ->suffix('хв'),
                Textarea::make('synopsis')
                    ->label('Опис')
                    ->rows(4)
                    ->columnSpanFull(),
                Textarea::make('synopsis_uk')
                    ->label('Опис (українською)')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}
