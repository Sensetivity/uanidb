<?php

namespace App\Filament\Resources\People\Pages;

use App\Filament\Resources\People\PersonResource;
use App\Models\Person;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EditPerson extends EditRecord
{
    protected static string $resource = PersonResource::class;

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

        if ($imagePath && $record instanceof Person) {
            $fullPath = Storage::disk('public')->path($imagePath);
            $record->clearMediaCollection('main_image');
            $record->addMedia($fullPath)->toMediaCollection('main_image');
        }
    }
}
