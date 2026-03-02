<?php

namespace App\Filament\Resources\Studios\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StudioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('mal_id')
                    ->label('MAL ID')
                    ->numeric(),
                Textarea::make('about')
                    ->rows(4)
                    ->columnSpanFull(),
                TextInput::make('logo_url')
                    ->label('Logo URL')
                    ->url()
                    ->maxLength(500),
                TextInput::make('website')
                    ->url()
                    ->maxLength(500),
            ]);
    }
}
