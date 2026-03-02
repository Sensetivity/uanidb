<?php

namespace App\Filament\Resources\Animes\Schemas;

use App\Models\Anime;
use App\Models\AnimeTitle;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AnimeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ImageEntry::make('poster')
                    ->state(fn (Anime $record): ?string => $record->getFirstMediaUrl('main_poster') ?: $record->image_url)
                    ->height(280)
                    ->columnSpan(1),
                TextEntry::make('mal_id')->label('MAL ID'),
                TextEntry::make('anidb_id')->label('AniDB ID'),
                TextEntry::make('title'),
                TextEntry::make('type')->badge(),
                TextEntry::make('status')->badge(),
                TextEntry::make('score'),
                TextEntry::make('rank'),
                TextEntry::make('popularity'),
                TextEntry::make('aired_from')->date(),
                TextEntry::make('aired_to')->date(),
                TextEntry::make('synopsis')->columnSpanFull(),
                TextEntry::make('synopsis_uk')->label('Synopsis (Ukrainian)')->columnSpanFull(),
                TextEntry::make('ukrainian_titles')
                    ->label('Українські назви')
                    ->state(
                        fn (Anime $record): string => $record->titles()
                        ->where('language', 'uk')
                        ->get()
                        ->map(fn (AnimeTitle $t): string => "[{$t->source->getLabel()}] {$t->title}")
                        ->implode(', ') ?: '—'
                    )
                    ->columnSpanFull(),
            ]);
    }
}
