<?php

namespace App\Filament\Resources\Characters\Tables;

use App\Models\Character;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CharactersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->state(fn (Character $record): ?string => $record->getFirstMediaUrl('main_image') ?: $record->image_url)
                    ->width(40)
                    ->height(56)
                    ->defaultImageUrl(null),
                TextColumn::make('name')
                    ->searchable(['name', 'mal_id'])
                    ->sortable(),
                TextColumn::make('japanese_name')
                    ->toggleable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make()->iconButton(),
                EditAction::make()->iconButton(),
                ActionGroup::make([
                    Action::make('download_image')
                        ->label('Download Image')
                        ->icon('heroicon-o-photo')
                        ->color('gray')
                        ->action(function (Character $record): void {
                            if (! $record->image_url) {
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
                    ->icon('heroicon-o-ellipsis-vertical')
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
