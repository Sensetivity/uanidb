<?php

namespace App\Filament\Resources\Themes\Pages;

use App\Filament\Concerns\FullWidthPage;
use App\Filament\Resources\Themes\ThemeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTheme extends ViewRecord
{
    use FullWidthPage;

    protected static string $resource = ThemeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
