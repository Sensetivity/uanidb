<?php

namespace App\Filament\Resources\Themes\Schemas;

use App\Enums\ThemeType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ThemeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('mal_title')
                    ->label('MAL Title')
                    ->required()
                    ->maxLength(100),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('type')
                    ->options(ThemeType::class)
                    ->required(),
                Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
