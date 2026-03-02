<?php

namespace App\Filament\Resources\Characters\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CharacterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('mal_id')
                    ->label('MAL ID')
                    ->numeric(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('japanese_name')
                    ->maxLength(255),
                Textarea::make('about')
                    ->rows(4)
                    ->columnSpanFull(),
                TextInput::make('image_url')
                    ->label('Image URL')
                    ->url()
                    ->maxLength(500)
                    ->columnSpanFull(),
            ]);
    }
}
