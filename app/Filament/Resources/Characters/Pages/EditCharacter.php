<?php

namespace App\Filament\Resources\Characters\Pages;

use App\Filament\Resources\Characters\CharacterResource;
use App\Models\Character;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EditCharacter extends EditRecord
{
    protected static string $resource = CharacterResource::class;

    protected function afterSave(): void
    {
        $this->handleImageUpload($this->record);
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    private function handleImageUpload(Model $record): void
    {
        $data = $this->form->getState();
        $imagePath = $data['main_image_upload'] ?? null;

        if ($imagePath && $record instanceof Character) {
            $fullPath = Storage::disk('public')->path($imagePath);
            $record->clearMediaCollection('main_image');
            $record->addMedia($fullPath)->toMediaCollection('main_image');
        }
    }
}
