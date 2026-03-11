<?php

namespace App\Filament\Resources\Episodes\Pages;

use App\Filament\Concerns\FullWidthPage;
use App\Filament\Resources\Episodes\EpisodeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewEpisode extends ViewRecord
{
    use FullWidthPage;

    protected static string $resource = EpisodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
