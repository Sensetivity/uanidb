<?php

namespace App\Filament\Resources\Characters\Schemas;

use App\Models\Character;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;

class CharacterInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Flex::make([
                    Section::make()
                        ->schema([
                            ImageEntry::make('image')
                                ->label('')
                                ->state(fn (Character $record): ?string => $record->getFirstMediaUrl('main_image') ?: $record->image_url)
                                ->imageHeight(400)
                                ->imageWidth('100%')
                                ->extraImgAttributes([
                                    'class' => 'rounded-lg object-cover w-full',
                                    'style' => 'aspect-ratio: 2/3;',
                                ]),
                            TextEntry::make('mal_id')
                                ->label('MAL ID')
                                ->icon('heroicon-o-link')
                                ->url(fn (Character $record): ?string => $record->mal_id
                                    ? "https://myanimelist.net/character/{$record->mal_id}"
                                    : null)
                                ->openUrlInNewTab()
                                ->color('primary')
                                ->placeholder('—'),
                        ])
                        ->grow(false)
                        ->extraAttributes(['style' => 'min-width: 280px; max-width: 320px;']),

                    Section::make()
                        ->schema([
                            TextEntry::make('name')
                                ->label('')
                                ->size(TextSize::Large)
                                ->weight(FontWeight::Bold),
                            TextEntry::make('japanese_name')
                                ->label('')
                                ->color('gray')
                                ->placeholder('—'),
                            TextEntry::make('about')
                                ->label('Біографія')
                                ->markdown()
                                ->prose()
                                ->placeholder('Інформація відсутня'),
                        ])
                        ->grow(),
                ])->from('md'),
            ]);
    }
}
