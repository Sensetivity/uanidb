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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class AnimesTable
{
    public static function configure(Table $table): Table
    {
        return $table
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
                    Action::make('translate')
                        ->label('Translate')
                        ->icon('heroicon-o-language')
                        ->action(function ($record): void {
                            TranslateAnimeJob::dispatch($record->id, withEpisodes: true);

                            Notification::make()
                                ->title('Переклад поставлено в чергу')
                                ->success()
                                ->send();
                        }),
                    Action::make('reimport')
                        ->label('Re-import')
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning')
                        ->action(function ($record): void {
                            ImportAnimeJob::dispatch($record->mal_id, true, true, false);

                            Notification::make()
                                ->title('Повторний імпорт поставлено в чергу')
                                ->success()
                                ->send();
                        }),
                    Action::make('reimport_images')
                        ->label('Re-import Images')
                        ->icon('heroicon-o-photo')
                        ->color('warning')
                        ->action(function ($record): void {
                            DownloadAnimeImagesJob::dispatch($record->id);

                            Notification::make()
                                ->title('Завантаження зображень поставлено в чергу')
                                ->success()
                                ->send();
                        }),
                    Action::make('reimport_episodes')
                        ->label('Re-import Episodes')
                        ->icon('heroicon-o-film')
                        ->color('gray')
                        ->action(function ($record): void {
                            ImportEpisodesJob::dispatch($record->id);

                            Notification::make()
                                ->title('Імпорт епізодів поставлено в чергу')
                                ->success()
                                ->send();
                        }),
                    Action::make('reimport_characters')
                        ->label('Re-import Characters & Staff')
                        ->icon('heroicon-o-users')
                        ->color('gray')
                        ->action(function ($record): void {
                            ImportCharactersStaffJob::dispatch($record->id);

                            Notification::make()
                                ->title('Імпорт персонажів поставлено в чергу')
                                ->success()
                                ->send();
                        }),
                    Action::make('reimport_videos')
                        ->label('Re-import Videos')
                        ->icon('heroicon-o-video-camera')
                        ->color('gray')
                        ->action(function ($record): void {
                            ImportVideosJob::dispatch($record->id);

                            Notification::make()
                                ->title('Імпорт відео поставлено в чергу')
                                ->success()
                                ->send();
                        }),
                    Action::make('import_anidb_titles')
                        ->label('Import AniDB Titles')
                        ->icon('heroicon-o-tag')
                        ->color('info')
                        ->action(function ($record): void {
                            ImportAniDbTitlesJob::dispatch($record->id);

                            Notification::make()
                                ->title('Імпорт назв AniDB поставлено в чергу')
                                ->success()
                                ->send();
                        }),
                    Action::make('import_anidb_episode_titles')
                        ->label('Import AniDB Episode Titles')
                        ->icon('heroicon-o-queue-list')
                        ->color('info')
                        ->action(function ($record): void {
                            ImportAniDbEpisodeTitlesJob::dispatch($record->id);

                            Notification::make()
                                ->title('Імпорт назв епізодів AniDB поставлено в чергу')
                                ->success()
                                ->send();
                        }),
                ])
                    ->icon('heroicon-o-ellipsis-vertical')
                    ->tooltip('More actions'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('bulk_translate')
                        ->label('Translate selected')
                        ->icon('heroicon-o-language')
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
}
