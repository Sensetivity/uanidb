<?php

namespace App\Filament\Resources\Animes\Pages;

use App\Filament\Resources\Animes\AnimeResource;
use App\Models\Anime;
use App\Services\TitleImport\TitleImportService;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EditAnime extends EditRecord
{
    protected static string $resource = AnimeResource::class;

    protected function afterSave(): void
    {
        $this->handlePosterUpload($this->record);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('importFromAniDb')
                ->label('Імпортувати з AniDB')
                ->icon(Heroicon::ArrowDownTray)
                ->visible()
                ->action(function (TitleImportService $service): void {
                    /** @var Anime $anime */
                    $anime = $this->getRecord();
                    $count = $service->importAnime($anime);

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

    private function handlePosterUpload(Model $record): void
    {
        $data = $this->form->getState();
        $posterPath = $data['main_poster_upload'] ?? null;

        if ($posterPath && $record instanceof Anime) {
            $fullPath = Storage::disk('public')->path($posterPath);
            $record->clearMediaCollection('main_poster');
            $record->addMedia($fullPath)->toMediaCollection('main_poster');
        }
    }
}
