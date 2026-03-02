<?php

namespace App\Filament\Resources\Characters\Schemas;

use App\Models\Character;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CharacterInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ImageEntry::make('image')
                    ->state(fn (Character $record): ?string => $record->getFirstMediaUrl('main_image') ?: $record->image_url)
                    ->height(280)
                    ->columnSpan(1),
                TextEntry::make('mal_id')->label('MAL ID'),
                TextEntry::make('name'),
                TextEntry::make('japanese_name'),
                TextEntry::make('about')->columnSpanFull(),
            ]);
    }
}
