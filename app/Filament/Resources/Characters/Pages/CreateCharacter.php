<?php

namespace App\Filament\Resources\Characters\Pages;

use App\Filament\Resources\Characters\CharacterResource;
use App\Models\Character;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CreateCharacter extends CreateRecord
{
    protected static string $resource = CharacterResource::class;

    protected function afterCreate(): void
    {
        if ($this->record) {
            $this->handleImageUpload($this->record);
        }
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
