<?php

namespace App\Filament\Resources\People\Tables;

use App\Models\Person;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PeopleTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('media'))
            ->columns([
                ImageColumn::make('image')
                    ->label('Зображення')
                    ->state(fn (Person $record): ?string => $record->image_display_url)
                    ->width(40)
                    ->height(56)
                    ->defaultImageUrl(null),
                TextColumn::make('name')
                    ->label("Ім'я")
                    ->searchable(['name', 'mal_id'])
                    ->sortable(),
                TextColumn::make('japanese_name')
                    ->label("Японське ім'я")
                    ->toggleable(),
                TextColumn::make('birth_date')
                    ->label('Дата народження')
                    ->date()
                    ->sortable(),
                TextColumn::make('deleted_at')
                    ->label('Стан')
                    ->badge()
                    ->formatStateUsing(fn ($state): ?string => $state ? 'Видалено' : null)
                    ->color('danger')
                    ->placeholder('')
                    ->toggleable()
                    ->sortable(),
            ])
            ->defaultSort('name')
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                RestoreAction::make()->iconButton(),
                ActionGroup::make([
                    Action::make('download_image')
                        ->label('Завантажити зображення')
                        ->icon(Heroicon::OutlinedPhoto)
                        ->color('gray')
                        ->visible()
                        ->action(function (Person $record): void {
                            if (!$record->image_url) {
                                Notification::make()
                                    ->title('URL зображення відсутній')
                                    ->warning()
                                    ->send();

                                return;
                            }

                            $record->clearMediaCollection('main_image');
                            $record->addMediaFromUrl($record->image_url)
                                ->toMediaCollection('main_image');

                            Notification::make()
                                ->title('Зображення завантажено')
                                ->success()
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
