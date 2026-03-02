<?php

namespace App\Filament\Resources\Animes\Pages;

use App\Filament\Resources\Animes\AnimeResource;
use App\Services\TitleImport\TitleImportService;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditAnime extends EditRecord
{
    protected static string $resource = AnimeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('importFromAniDb')
                ->label('Імпортувати з AniDB')
                ->icon(Heroicon::ArrowDownTray)
                ->action(function (TitleImportService $service): void {
                    $count = $service->importAnime($this->record);

                    Notification::make()
                        ->title("Імпортовано {$count} назв(и)")
                        ->success()
                        ->send();
                }),
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
