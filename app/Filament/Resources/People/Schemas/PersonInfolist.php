<?php

namespace App\Filament\Resources\People\Schemas;

use App\Models\Person;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;

class PersonInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'md' => 12])
                    ->schema([
                        self::sidebarSection(),
                        self::mainContentSection(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    private static function mainContentSection(): Section
    {
        return Section::make()
            ->schema([
                TextEntry::make('name')
                    ->hiddenLabel()
                    ->size(TextSize::Large)
                    ->weight(FontWeight::Bold),
                TextEntry::make('japanese_name')
                    ->label('Японське ім\'я')
                    ->placeholder('—'),
                TextEntry::make('birth_date')
                    ->label('Дата народження')
                    ->date('d.m.Y')
                    ->placeholder('—'),

                Grid::make(3)
                    ->schema([
                        TextEntry::make('animes_count')
                            ->label('Аніме')
                            ->state(fn (Person $record): int => $record->animes()->count())
                            ->icon(Heroicon::OutlinedTv),
                        TextEntry::make('voiced_characters_count')
                            ->label('Озвучені персонажі')
                            ->state(fn (Person $record): int => $record->voicedCharacters()->count())
                            ->icon(Heroicon::OutlinedUserGroup),
                    ]),

                Section::make('Біографія')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->schema([
                        TextEntry::make('about')
                            ->hiddenLabel()
                            ->markdown()
                            ->prose()
                            ->placeholder('Інформація відсутня'),
                    ])
                    ->collapsible(),
            ])
            ->columnSpan(['default' => 1, 'md' => 8]);
    }

    private static function sidebarSection(): Section
    {
        return Section::make()
            ->schema([
                ImageEntry::make('photo')
                    ->hiddenLabel()
                    ->state(fn (Person $record): ?string => $record->image_display_url)
                    ->imageHeight(350)
                    ->imageWidth('100%')
                    ->extraImgAttributes([
                        'class' => 'rounded-lg object-cover w-full',
                    ]),

                TextEntry::make('mal_id')
                    ->label('MAL')
                    ->icon(Heroicon::OutlinedLink)
                    ->url(fn (Person $record): ?string => $record->mal_id
                        ? "https://myanimelist.net/people/{$record->mal_id}"
                        : null)
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->placeholder('—'),
            ])
            ->columnSpan(['default' => 1, 'md' => 4]);
    }
}
