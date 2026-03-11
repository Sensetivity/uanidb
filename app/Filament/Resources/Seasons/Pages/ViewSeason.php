<?php

namespace App\Filament\Resources\Seasons\Pages;

use App\Filament\Concerns\FullWidthPage;
use App\Filament\Resources\Seasons\SeasonResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSeason extends ViewRecord
{
    use FullWidthPage;

    protected static string $resource = SeasonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
