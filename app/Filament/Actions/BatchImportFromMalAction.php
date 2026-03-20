<?php

namespace App\Filament\Actions;

use App\Jobs\ImportAnimeJob;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;

class BatchImportFromMalAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'batch_import_from_mal';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label('Пакетний імпорт з MAL')
            ->icon(Heroicon::OutlinedQueueList)
            ->color('info')
            ->schema([
                TextInput::make('mal_ids')
                    ->label('MAL IDs (через кому)')
                    ->placeholder('1, 5, 21, 1735')
                    ->required()
                    ->helperText('Введіть MAL ID через кому'),
            ])
            ->action(function (array $data): void {
                $ids = array_filter(
                    array_map('trim', explode(',', $data['mal_ids'])),
                    fn (string $id): bool => is_numeric($id) && (int) $id > 0,
                );

                $ids = array_unique(array_map('intval', $ids));

                if (empty($ids)) {
                    Notification::make()
                        ->title('Не знайдено жодного валідного MAL ID')
                        ->danger()
                        ->send();

                    return;
                }

                foreach ($ids as $malId) {
                    ImportAnimeJob::dispatch($malId, false, true);
                }

                $count = count($ids);

                Notification::make()
                    ->title("Поставлено в чергу імпорт {$count} аніме")
                    ->success()
                    ->send();
            });
    }
}
