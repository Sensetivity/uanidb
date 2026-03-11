<?php

namespace App\Filament\Resources\Studios\Pages;

use App\Filament\Concerns\FullWidthPage;
use App\Filament\Resources\Studios\StudioResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewStudio extends ViewRecord
{
    use FullWidthPage;

    protected static string $resource = StudioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
