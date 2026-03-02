<?php

namespace App\Filament\Resources\Studios\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class StudioInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('mal_id')->label('MAL ID'),
                TextEntry::make('name'),
                TextEntry::make('website'),
                TextEntry::make('about')->columnSpanFull(),
            ]);
    }
}
