<?php

namespace App\Filament\Resources\Animes\Tables;

use App\Enums\AnimeStatusEnum;
use App\Enums\AnimeTypeEnum;
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
use Filament\Actions\RestoreAction;
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
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['seasons', 'media']))
            ->columns([
                ImageColumn::make('poster')
                    ->label('Постер')
                    ->state(fn (Anime $record): ?string => $record->poster_url)
                    ->width(40)
                    ->height(56)
                    ->defaultImageUrl(null),
                TextColumn::make('title')
                    ->label('Назва')
                    ->searchable(['title', 'mal_id'])
                    ->sortable()
                    ->limit(40),
                TextColumn::make('type')
                    ->label('Тип')
                    ->badge()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge()
                    ->sortable(),
                TextColumn::make('seasons.season_of_year')
                    ->label('Сезон')
                    ->formatStateUsing(fn ($state, Anime $record): string => $record->seasons
                        ->map(fn ($s): string => $s->name)
                        ->join(', '))
                    ->tooltip(fn (Anime $record): ?string => implode(' · ', array_filter([
                        $record->aired_from?->format('d M Y'),
                        $record->broadcast,
                    ])) ?: null),
                TextColumn::make('aired_from')
                    ->label('Рік')
                    ->date('Y')
                    ->sortable(),
                TextColumn::make('episodes_count')
                    ->counts('episodes')
                    ->label('Епізоди'),
                TextColumn::make('deleted_at')
                    ->label('Стан')
                    ->badge()
                    ->formatStateUsing(fn ($state): ?string => $state ? 'Видалено' : null)
                    ->color('danger')
                    ->placeholder('')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Тип')
                    ->options(AnimeTypeEnum::class),
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options(AnimeStatusEnum::class),
                TernaryFilter::make('synopsis_uk')
                    ->label('Переклад')
                    ->placeholder('Усі')
                    ->trueLabel('Перекладено')
                    ->falseLabel('Не перекладено')
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
                RestoreAction::make()->iconButton(),
                ActionGroup::make([
                    self::dispatchAction(
                        'translate',
                        'Перекласти',
                        Heroicon::OutlinedLanguage,
                        'Переклад поставлено в чергу',
                        fn (Anime $record) => TranslateAnimeJob::dispatch($record->id, withEpisodes: true)
                    ),
                    self::dispatchAction(
                        'reimport',
                        'Повторний імпорт',
                        Heroicon::OutlinedArrowPath,
                        'Повторний імпорт поставлено в чергу',
                        fn (Anime $record) => ImportAnimeJob::dispatch($record->mal_id, true),
                        'warning'
                    ),
                    self::dispatchAction(
                        'reimport_episodes',
                        'Повторний імпорт епізодів',
                        Heroicon::OutlinedFilm,
                        'Імпорт епізодів поставлено в чергу',
                        fn (Anime $record) => ImportEpisodesJob::dispatch($record->id),
                        'gray'
                    ),
                    self::dispatchAction(
                        'reimport_characters',
                        'Повторний імпорт персонажів',
                        Heroicon::OutlinedUsers,
                        'Імпорт персонажів поставлено в чергу',
                        fn (Anime $record) => ImportCharactersStaffJob::dispatch($record->id),
                        'gray'
                    ),
                    self::dispatchAction(
                        'reimport_videos',
                        'Повторний імпорт відео',
                        Heroicon::OutlinedVideoCamera,
                        'Імпорт відео поставлено в чергу',
                        fn (Anime $record) => ImportVideosJob::dispatch($record->id),
                        'gray'
                    ),
                    self::dispatchAction(
                        'import_anidb_titles',
                        'Імпорт назв AniDB',
                        Heroicon::OutlinedTag,
                        'Імпорт назв AniDB поставлено в чергу',
                        fn (Anime $record) => ImportAniDbTitlesJob::dispatch($record->id),
                        'info'
                    ),
                    self::dispatchAction(
                        'import_anidb_episode_titles',
                        'Імпорт назв епізодів AniDB',
                        Heroicon::OutlinedQueueList,
                        'Імпорт назв епізодів AniDB поставлено в чергу',
                        fn (Anime $record) => ImportAniDbEpisodeTitlesJob::dispatch($record->id),
                        'info'
                    ),
                ])
                    ->icon(Heroicon::OutlinedEllipsisVertical)
                    ->tooltip('Більше дій'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('bulk_translate')
                        ->label('Перекласти обрані')
                        ->icon(Heroicon::OutlinedLanguage)
                        ->visible()
                        ->action(function (Collection $records): void {
                            /** @var Anime $record */
                            foreach ($records as $record) {
                                TranslateAnimeJob::dispatch($record->id, withEpisodes: true);
                            }

                            Notification::make()
                                ->title('Переклад поставлено в чергу')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
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
            ->visible()
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
