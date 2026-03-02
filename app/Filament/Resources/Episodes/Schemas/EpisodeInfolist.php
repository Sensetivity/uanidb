<?php

namespace App\Filament\Resources\Episodes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EpisodeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('anime.title')
                    ->label('Anime'),
                TextEntry::make('number'),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('title')
                    ->label('Title (Romaji)'),
                TextEntry::make('title_en')
                    ->label('Title (EN)'),
                TextEntry::make('title_uk')
                    ->label('Title (UK)'),
                TextEntry::make('title_ja')
                    ->label('Title (JA)'),
                TextEntry::make('aired')
                    ->date(),
                TextEntry::make('duration')
                    ->suffix(' min'),
                TextEntry::make('synopsis')
                    ->columnSpanFull(),
                TextEntry::make('synopsis_uk')
                    ->label('Synopsis (Ukrainian)')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
