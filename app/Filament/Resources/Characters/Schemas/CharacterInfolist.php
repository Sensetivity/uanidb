<?php

namespace App\Filament\Resources\Characters\Schemas;

use App\Models\Character;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;

class CharacterInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'md' => 12])
                    ->columnSpanFull()
                    ->schema([
                        Section::make()
                            ->schema([
                                ImageEntry::make('image')
                                    ->hiddenLabel()
                                    ->state(fn (Character $record): ?string => $record->image_display_url)
                                    ->imageHeight(400)
                                    ->imageWidth('100%')
                                    ->extraImgAttributes([
                                        'class' => 'rounded-lg object-cover w-full',
                                        'style' => 'aspect-ratio: 2/3;',
                                    ]),
                                TextEntry::make('mal_id')
                                    ->label('MAL ID')
                                    ->icon(Heroicon::OutlinedLink)
                                    ->url(fn (Character $record): ?string => $record->mal_id
                                        ? "https://myanimelist.net/character/{$record->mal_id}"
                                        : null)
                                    ->openUrlInNewTab()
                                    ->color('primary')
                                    ->placeholder('—'),
                            ])
                            ->columnSpan(['default' => 1, 'md' => 3]),

                        Section::make()
                            ->schema([
                                TextEntry::make('name')
                                    ->hiddenLabel()
                                    ->size(TextSize::Large)
                                    ->weight(FontWeight::Bold),
                                TextEntry::make('japanese_name')
                                    ->hiddenLabel()
                                    ->color('gray')
                                    ->placeholder('—'),
                                TextEntry::make('about')
                                    ->label('Біографія')
                                    ->markdown()
                                    ->prose()
                                    ->placeholder('Інформація відсутня'),
                            ])
                            ->columnSpan(['default' => 1, 'md' => 9]),
                    ]),
            ]);
    }
}
