<?php

namespace App\Filament\Resources\People\Pages;

use App\Filament\Concerns\FullWidthPage;
use App\Filament\Resources\People\PersonResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPerson extends ViewRecord
{
    use FullWidthPage;

    protected static string $resource = PersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
