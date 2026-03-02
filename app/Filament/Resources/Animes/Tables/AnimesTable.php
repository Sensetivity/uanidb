<?php

namespace App\Filament\Resources\Animes\Tables;

use App\Enums\AnimeStatusEnum;
use App\Enums\AnimeTypeEnum;
use App\Jobs\DownloadAnimeImagesJob;
use App\Jobs\ImportAniDbEpisodeTitlesJob;
use App\Jobs\ImportAniDbTitlesJob;
use App\Jobs\ImportAnimeJob;
use App\Jobs\ImportCharactersStaffJob;
use App\Jobs\ImportEpisodesJob;
use App\Jobs\ImportVideosJob;
use App\Jobs\TranslateAnimeJob;
use App\Models\Anime;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class AnimesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with('seasons'))
            ->columns([
                ImageColumn::make('poster')
                    ->state(fn (Anime $record): ?string => $record->getFirstMediaUrl('main_poster') ?: $record->image_url)
                    ->width(40)
                    ->height(56)
                    ->defaultImageUrl(null),
                TextColumn::make('title')
                    ->searchable(['title', 'mal_id'])
                    ->sortable()
                    ->limit(40),
                TextColumn::make('type')
                    ->badge()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('seasons.name')
                    ->label('Season')
                    ->tooltip(fn (Anime $record): ?string => implode(' · ', array_filter([
                        $record->aired_from?->format('d M Y'),
                        $record->broadcast,
                    ])) ?: null),
                TextColumn::make('aired_from')
                    ->date('Y')
                    ->sortable(),
                TextColumn::make('episodes_count')
                    ->counts('episodes')
                    ->label('Episodes'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(AnimeTypeEnum::class),
                SelectFilter::make('status')
                    ->options(AnimeStatusEnum::class),
                TernaryFilter::make('synopsis_uk')
                    ->label('Translated')
                    ->placeholder('All')
                    ->trueLabel('Translated')
                    ->falseLabel('Not translated')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('synopsis_uk')->where('synopsis_uk', '!=', ''),
                        false: fn ($query) => $query->where(fn ($q) => $q->whereNull('synopsis_uk')->orWhere('synopsis_uk', '')),
                        blank: fn ($query) => $query,
                    ),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                ActionGroup::make([
                    self::dispatchAction(
                        'translate',
                        'Translate',
                        Heroicon::OutlinedLanguage,
                        'Переклад поставлено в чергу',
                        fn (Anime $record) => TranslateAnimeJob::dispatch($record->id, withEpisodes: true)
                    ),
                    self::dispatchAction(
                        'reimport',
                        'Re-import',
                        Heroicon::OutlinedArrowPath,
                        'Повторний імпорт поставлено в чергу',
                        fn (Anime $record) => ImportAnimeJob::dispatch($record->mal_id, true, true, false),
                        'warning'
                    ),
                    self::dispatchAction(
                        'reimport_images',
                        'Re-import Images',
                        Heroicon::OutlinedPhoto,
                        'Завантаження зображень поставлено в чергу',
                        fn (Anime $record) => DownloadAnimeImagesJob::dispatch($record->id),
                        'warning'
                    ),
                    self::dispatchAction(
                        'reimport_episodes',
                        'Re-import Episodes',
                        Heroicon::OutlinedFilm,
                        'Імпорт епізодів поставлено в чергу',
                        fn (Anime $record) => ImportEpisodesJob::dispatch($record->id),
                        'gray'
                    ),
                    self::dispatchAction(
                        'reimport_characters',
                        'Re-import Characters & Staff',
                        Heroicon::OutlinedUsers,
                        'Імпорт персонажів поставлено в чергу',
                        fn (Anime $record) => ImportCharactersStaffJob::dispatch($record->id),
                        'gray'
                    ),
                    self::dispatchAction(
                        'reimport_videos',
                        'Re-import Videos',
                        Heroicon::OutlinedVideoCamera,
                        'Імпорт відео поставлено в чергу',
                        fn (Anime $record) => ImportVideosJob::dispatch($record->id),
                        'gray'
                    ),
                    self::dispatchAction(
                        'import_anidb_titles',
                        'Import AniDB Titles',
                        Heroicon::OutlinedTag,
                        'Імпорт назв AniDB поставлено в чергу',
                        fn (Anime $record) => ImportAniDbTitlesJob::dispatch($record->id),
                        'info'
                    ),
                    self::dispatchAction(
                        'import_anidb_episode_titles',
                        'Import AniDB Episode Titles',
                        Heroicon::OutlinedQueueList,
                        'Імпорт назв епізодів AniDB поставлено в чергу',
                        fn (Anime $record) => ImportAniDbEpisodeTitlesJob::dispatch($record->id),
                        'info'
                    ),
                ])
                    ->icon(Heroicon::OutlinedEllipsisVertical)
                    ->tooltip('More actions'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('bulk_translate')
                        ->label('Translate selected')
                        ->icon(Heroicon::OutlinedLanguage)
                        ->action(function (Collection $records): void {
                            foreach ($records as $record) {
                                TranslateAnimeJob::dispatch($record->id, withEpisodes: true);
                            }

                            Notification::make()
                                ->title('Переклад поставлено в чергу')
                                ->success()
                                ->send();
                        }),
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }

    private static function dispatchAction(
        string $name,
        string $label,
        string|BackedEnum $icon,
        string $notification,
        \Closure $dispatch,
        ?string $color = null,
    ): Action {
        $action = Action::make($name)
            ->label($label)
            ->icon($icon)
            ->action(function (Anime $record) use ($dispatch, $notification): void {
                $dispatch($record);

                Notification::make()
                    ->title($notification)
                    ->success()
                    ->send();
            });

        if ($color) {
            $action->color($color);
        }

        return $action;
    }
}
