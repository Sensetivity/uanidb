<?php

namespace App\Filament\Resources\Animes\Pages;

use App\Filament\Actions\ImportFromMalAction;
use App\Filament\Resources\Animes\AnimeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAnimes extends ListRecords
{
    protected static string $resource = AnimeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportFromMalAction::make(),
            CreateAction::make(),
        ];
    }
}
