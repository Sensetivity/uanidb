<?php

namespace App\Filament\Resources\Animes\Pages;

use App\Filament\Resources\Animes\AnimeResource;
use App\Models\Anime;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CreateAnime extends CreateRecord
{
    protected static string $resource = AnimeResource::class;

    protected function afterCreate(): void
    {
        if ($this->record) {
            $this->handlePosterUpload($this->record);
        }
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
