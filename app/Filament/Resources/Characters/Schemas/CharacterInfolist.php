<?php

namespace App\Filament\Resources\Characters\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CharacterInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('mal_id')->label('MAL ID'),
                TextEntry::make('name'),
                TextEntry::make('japanese_name'),
                TextEntry::make('image_url')->label('Image URL'),
                TextEntry::make('about')->columnSpanFull(),
            ]);
    }
}
