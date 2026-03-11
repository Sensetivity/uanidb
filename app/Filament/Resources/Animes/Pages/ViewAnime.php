<?php

namespace App\Filament\Resources\Animes\Pages;

use App\Filament\Concerns\FullWidthPage;
use App\Filament\Resources\Animes\AnimeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;

class ViewAnime extends ViewRecord
{
    use FullWidthPage;

    protected static string $resource = AnimeResource::class;
    protected string $view = 'filament.pages.view-record-with-content';

    public function resolveRecord(int|string $key): Model
    {
        return parent::resolveRecord($key)->loadMissing([
            'genres',
            'themes',
            'studios',
            'titles',
            'media',
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
