<?php

namespace App\Filament\Resources\Animes\Schemas;

use App\Models\Anime;
use App\Models\AnimeTitle;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;

class AnimeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Flex::make([
                    self::sidebarSection(),
                    self::mainContentSection(),
                ])->from('md'),
            ]);
    }

    private static function mainContentSection(): Section
    {
        return Section::make()
            ->schema([
                TextEntry::make('title')
                    ->label('')
                    ->size(TextSize::Large)
                    ->weight(FontWeight::Bold),
                TextEntry::make('alternative_titles')
                    ->label('')
                    ->state(fn (Anime $record): string => $record->titles()
                        ->get()
                        ->map(fn (AnimeTitle $t): string => $t->title)
                        ->unique()
                        ->implode(' | ') ?: '—')
                    ->color('gray'),

                Section::make('Інформація')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Grid::make(['default' => 1, 'sm' => 3, 'lg' => 3])
                            ->schema([
                                TextEntry::make('type')
                                    ->label('Тип')
                                    ->badge(),
                                TextEntry::make('episode_count')
                                    ->label('Епізоди')
                                    ->placeholder('—'),
                                TextEntry::make('status')
                                    ->label('Статус')
                                    ->badge(),
                                TextEntry::make('aired_from')
                                    ->label('Початок показу')
                                    ->date('d.m.Y')
                                    ->placeholder('—'),
                                TextEntry::make('aired_to')
                                    ->label('Кінець показу')
                                    ->date('d.m.Y')
                                    ->placeholder('—'),
                                TextEntry::make('duration')
                                    ->label('Тривалість')
                                    ->formatStateUsing(fn (?int $state): string => $state ? "{$state} хв." : '—')
                                    ->placeholder('—'),
                                TextEntry::make('source_type')
                                    ->label('Джерело')
                                    ->placeholder('—'),
                                TextEntry::make('rating')
                                    ->label('Рейтинг')
                                    ->placeholder('—'),
                                TextEntry::make('broadcast')
                                    ->label('Трансляція')
                                    ->placeholder('—'),
                            ]),
                        TextEntry::make('genres_list')
                            ->label('Жанри')
                            ->state(fn (Anime $record): string => $record->genres()
                                ->pluck('name')
                                ->implode(', ') ?: '—')
                            ->badge()
                            ->separator(',')
                            ->color('primary'),
                        TextEntry::make('themes_list')
                            ->label('Теми')
                            ->state(fn (Anime $record): string => $record->themes()
                                ->pluck('name')
                                ->implode(', ') ?: '—')
                            ->badge()
                            ->separator(',')
                            ->color('gray'),
                        TextEntry::make('studios_list')
                            ->label('Студії')
                            ->state(fn (Anime $record): string => $record->studios()
                                ->pluck('name')
                                ->implode(', ') ?: '—')
                            ->icon('heroicon-o-building-office'),
                    ])
                    ->collapsible(),

                Section::make('Опис')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        TextEntry::make('synopsis')
                            ->label('Англійською')
                            ->markdown()
                            ->prose()
                            ->placeholder('Опис відсутній'),
                        TextEntry::make('synopsis_uk')
                            ->label('Українською')
                            ->markdown()
                            ->prose()
                            ->placeholder('Переклад відсутній'),
                    ])
                    ->collapsible(),

                Section::make('Українські назви')
                    ->icon('heroicon-o-language')
                    ->schema([
                        TextEntry::make('ukrainian_titles')
                            ->label('')
                            ->state(
                                fn (Anime $record): string => $record->titles()
                                    ->where('language', 'uk')
                                    ->get()
                                    ->map(fn (AnimeTitle $t): string => "[{$t->source->getLabel()}] {$t->title}")
                                    ->implode("\n") ?: '—'
                            ),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ])
            ->grow();
    }

    private static function sidebarSection(): Section
    {
        return Section::make()
            ->schema([
                ImageEntry::make('poster')
                    ->label('')
                    ->state(fn (Anime $record): ?string => $record->getFirstMediaUrl('main_poster') ?: $record->image_url)
                    ->imageHeight(350)
                    ->imageWidth('100%')
                    ->extraImgAttributes([
                        'class' => 'rounded-lg object-cover w-full',
                        'style' => 'aspect-ratio: 225/350;',
                    ]),

                Section::make('Оцінка')
                    ->schema([
                        TextEntry::make('score')
                            ->label('')
                            ->size(TextSize::Large)
                            ->weight(FontWeight::Bold)
                            ->icon('heroicon-s-star')
                            ->color('warning')
                            ->placeholder('N/A'),
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('rank')
                                    ->label('Рейтинг')
                                    ->formatStateUsing(fn (?int $state): string => $state ? "#{$state}" : '—')
                                    ->icon('heroicon-o-trophy')
                                    ->placeholder('—'),
                                TextEntry::make('popularity')
                                    ->label('Популярність')
                                    ->icon('heroicon-o-heart')
                                    ->placeholder('—'),
                            ]),
                    ]),

                TextEntry::make('mal_id')
                    ->label('MAL')
                    ->icon('heroicon-o-link')
                    ->url(fn (Anime $record): ?string => $record->mal_id
                        ? "https://myanimelist.net/anime/{$record->mal_id}"
                        : null)
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->placeholder('—'),
                TextEntry::make('anidb_id')
                    ->label('AniDB')
                    ->icon('heroicon-o-link')
                    ->url(fn (Anime $record): ?string => $record->anidb_id
                        ? "https://anidb.net/anime/{$record->anidb_id}"
                        : null)
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->placeholder('—'),
            ])
            ->grow(false)
            ->extraAttributes(['style' => 'min-width: 280px; max-width: 320px;']);
    }
}
