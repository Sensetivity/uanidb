<?php

namespace App\Filament\Resources\Characters\Pages;

use App\Filament\Concerns\FullWidthPage;
use App\Filament\Resources\Characters\CharacterResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;

class ViewCharacter extends ViewRecord
{
    use FullWidthPage;

    protected static string $resource = CharacterResource::class;
    protected string $view = 'filament.pages.view-record-with-content';

    public function resolveRecord(int|string $key): Model
    {
        return parent::resolveRecord($key)->loadMissing(['media']);
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
