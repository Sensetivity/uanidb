<?php

namespace App\Filament\Actions;

use App\Jobs\ImportAnimeJob;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;

class ImportFromMalAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'import_from_mal';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label('Імпорт з MAL')
            ->icon(Heroicon::OutlinedArrowDownTray)
            ->schema([
                TextInput::make('mal_id')
                    ->label('MAL ID')
                    ->numeric()
                    ->required(),
            ])
            ->action(function (array $data): void {
                ImportAnimeJob::dispatch((int) $data['mal_id'], false, true, true);

                Notification::make()
                    ->title('Імпорт поставлено в чергу')
                    ->success()
                    ->send();
            });
    }
}
