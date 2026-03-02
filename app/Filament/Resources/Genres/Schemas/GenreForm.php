<?php

namespace App\Filament\Resources\Genres\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GenreForm
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
                    ->unique()
                    ->maxLength(255),
            ]);
    }
}
