<?php

namespace App\Filament\Resources\Episodes\Tables;

use App\Enums\EpisodeTypeEnum;
use App\Models\Episode;
use App\Services\TitleImport\TitleImportService;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class EpisodesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('anime.title')
                    ->label('Аніме')
                    ->limit(30)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('title')
                    ->label('Назва (ромадзі)')
                    ->limit(40),
                TextColumn::make('title_en')
                    ->label('Назва (EN)')
                    ->limit(40)
                    ->toggleable(),
                TextColumn::make('title_uk')
                    ->label('Назва (UK)')
                    ->limit(40)
                    ->toggleable(),
                TextColumn::make('aired')
                    ->label('Дата виходу')
                    ->date()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Тип')
                    ->badge(),
                TextColumn::make('deleted_at')
                    ->label('Стан')
                    ->badge()
                    ->formatStateUsing(fn ($state): ?string => $state ? 'Видалено' : null)
                    ->color('danger')
                    ->placeholder('')
                    ->toggleable()
                    ->sortable(),
            ])
            ->defaultSort('aired', 'desc')
            ->filters([
                SelectFilter::make('anime_id')
                    ->label('Аніме')
                    ->relationship('anime', 'title')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('type')
                    ->label('Тип')
                    ->options(EpisodeTypeEnum::class),
                TernaryFilter::make('title_uk')
                    ->label('Переклад')
                    ->placeholder('Усі')
                    ->trueLabel('Перекладено')
                    ->falseLabel('Не перекладено')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('title_uk')->where('title_uk', '!=', ''),
                        false: fn ($query) => $query->where(fn ($q) => $q->whereNull('title_uk')->orWhere('title_uk', '')),
                        blank: fn ($query) => $query,
                    ),
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                RestoreAction::make()->iconButton(),
                ActionGroup::make([
                    Action::make('import_anidb_title')
                        ->label('Імпорт назви AniDB')
                        ->icon(Heroicon::OutlinedTag)
                        ->color('info')
                        ->visible()
                        ->action(function (Episode $record): void {
                            $imported = app(TitleImportService::class)->importEpisode($record, force: true);

                            Notification::make()
                                ->title($imported ? 'Назву епізоду імпортовано' : 'Назву не знайдено в AniDB')
                                ->status($imported ? 'success' : 'warning')
                                ->send();
                        }),
                ])
                    ->icon(Heroicon::OutlinedEllipsisVertical)
                    ->tooltip('Більше дій'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
