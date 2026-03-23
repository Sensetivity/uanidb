<?php

namespace App\Filament\Resources\People\Pages;

use App\Filament\Resources\People\PersonResource;
use App\Models\Person;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CreatePerson extends CreateRecord
{
    protected static string $resource = PersonResource::class;

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

        if ($imagePath && $record instanceof Person) {
            $fullPath = Storage::disk('public')->path($imagePath);
            $record->clearMediaCollection('main_image');
            $record->addMedia($fullPath)->toMediaCollection('main_image');
        }
    }
}
