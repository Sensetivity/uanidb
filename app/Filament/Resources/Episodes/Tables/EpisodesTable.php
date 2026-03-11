<?php

namespace App\Filament\Resources\Episodes\Tables;

use App\Models\Episode;
use App\Services\TitleImport\TitleImportService;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class EpisodesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('anime.title')
                    ->label('Anime')
                    ->limit(30)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('title')
                    ->label('Title (Romaji)')
                    ->limit(40),
                TextColumn::make('title_en')
                    ->label('Title (EN)')
                    ->limit(40)
                    ->toggleable(),
                TextColumn::make('title_uk')
                    ->label('Title (UK)')
                    ->limit(40)
                    ->toggleable(),
                TextColumn::make('aired')
                    ->date()
                    ->sortable(),
                TextColumn::make('type')
                    ->badge(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                ActionGroup::make([
                    Action::make('import_anidb_title')
                        ->label('Import AniDB Title')
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
                    ->tooltip('More actions'),
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
