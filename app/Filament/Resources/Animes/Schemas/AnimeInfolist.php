<?php

namespace App\Filament\Resources\Animes\Schemas;

use App\Models\Anime;
use App\Models\AnimeTitle;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;

class AnimeInfolist
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
                TextEntry::make('title')
                    ->hiddenLabel()
                    ->size(TextSize::Large)
                    ->weight(FontWeight::Bold),
                TextEntry::make('alternative_titles')
                    ->hiddenLabel()
                    ->state(fn (Anime $record): string => $record->titles
                        ->pluck('title')
                        ->unique()
                        ->implode(' | ') ?: '—')
                    ->color('gray'),

                Section::make('Інформація')
                    ->icon(Heroicon::OutlinedInformationCircle)
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
                            ->state(fn (Anime $record): string => $record->genres
                                ->pluck('name')
                                ->implode(', ') ?: '—')
                            ->badge()
                            ->separator(', ')
                            ->color('primary'),
                        TextEntry::make('themes_list')
                            ->label('Теми')
                            ->state(fn (Anime $record): string => $record->themes
                                ->pluck('name')
                                ->implode(', ') ?: '—')
                            ->badge()
                            ->separator(', ')
                            ->color('gray'),
                        TextEntry::make('studios_list')
                            ->label('Студії')
                            ->state(fn (Anime $record): string => $record->studios
                                ->pluck('name')
                                ->implode(', ') ?: '—')
                            ->icon(Heroicon::OutlinedBuildingOffice),
                    ])
                    ->collapsible(),

                Section::make('Опис')
                    ->icon(Heroicon::OutlinedDocumentText)
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

                Section::make('Медіа')
                    ->icon(Heroicon::OutlinedPhoto)
                    ->schema([
                        Grid::make(['default' => 1, 'sm' => 2])
                            ->schema([
                                TextEntry::make('posters_count')
                                    ->label('Постери')
                                    ->state(fn (Anime $record): string => (string) $record->getMedia('posters')->count())
                                    ->icon(Heroicon::OutlinedPhoto)
                                    ->placeholder('0'),
                                TextEntry::make('screenshots_count')
                                    ->label('Скріншоти')
                                    ->state(fn (Anime $record): string => (string) $record->getMedia('screenshots')->count())
                                    ->icon(Heroicon::OutlinedCamera)
                                    ->placeholder('0'),
                            ]),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Section::make('Українські назви')
                    ->icon(Heroicon::OutlinedLanguage)
                    ->schema([
                        TextEntry::make('ukrainian_titles')
                            ->hiddenLabel()
                            ->state(
                                fn (Anime $record): string => $record->titles
                                    ->where('language', 'uk')
                                    ->map(fn (AnimeTitle $t): string => "[{$t->source->getLabel()}] {$t->title}")
                                    ->implode("\n") ?: '—'
                            ),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ])
            ->columnSpan(['default' => 1, 'md' => 8]);
    }

    private static function sidebarSection(): Section
    {
        return Section::make()
            ->schema([
                ImageEntry::make('poster')
                    ->hiddenLabel()
                    ->state(fn (Anime $record): ?string => $record->poster_url)
                    ->imageHeight(350)
                    ->imageWidth('100%')
                    ->extraImgAttributes([
                        'class' => 'rounded-lg object-cover w-full',
                        'style' => 'aspect-ratio: 225/350;',
                    ]),

                Section::make('Оцінка')
                    ->schema([
                        TextEntry::make('score')
                            ->hiddenLabel()
                            ->size(TextSize::Large)
                            ->weight(FontWeight::Bold)
                            ->icon(Heroicon::Star)
                            ->color('warning')
                            ->placeholder('N/A'),
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('rank')
                                    ->label('Рейтинг')
                                    ->formatStateUsing(fn (?int $state): string => $state ? "#{$state}" : '—')
                                    ->icon(Heroicon::OutlinedTrophy)
                                    ->placeholder('—'),
                                TextEntry::make('popularity')
                                    ->label('Популярність')
                                    ->icon(Heroicon::OutlinedHeart)
                                    ->placeholder('—'),
                            ]),
                    ]),

                TextEntry::make('mal_id')
                    ->label('MAL')
                    ->icon(Heroicon::OutlinedLink)
                    ->url(fn (Anime $record): ?string => $record->mal_id
                        ? "https://myanimelist.net/anime/{$record->mal_id}"
                        : null)
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->placeholder('—'),
                TextEntry::make('anidb_id')
                    ->label('AniDB')
                    ->icon(Heroicon::OutlinedLink)
                    ->url(fn (Anime $record): ?string => $record->anidb_id
                        ? "https://anidb.net/anime/{$record->anidb_id}"
                        : null)
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->placeholder('—'),
            ])
            ->columnSpan(['default' => 1, 'md' => 4]);
    }
}
