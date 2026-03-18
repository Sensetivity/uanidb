<?php

namespace App\Filament\Resources\ImportLogs\Schemas;

use App\Filament\Resources\Animes\AnimeResource;
use App\Models\ImportLog;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ImportLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Деталі імпорту')
                    ->icon(Heroicon::OutlinedInformationCircle)
                    ->schema([
                        TextEntry::make('id')
                            ->label('ID'),
                        TextEntry::make('job_type')
                            ->label('Тип завдання')
                            ->badge(),
                        TextEntry::make('status')
                            ->label('Статус')
                            ->badge(),
                        TextEntry::make('anime.title')
                            ->label('Аніме')
                            ->url(fn (ImportLog $record): ?string => $record->anime_id
                                ? AnimeResource::getUrl('view', ['record' => $record->anime_id])
                                : null)
                            ->placeholder('—'),
                        TextEntry::make('mal_id')
                            ->label('MAL ID')
                            ->placeholder('—'),
                        TextEntry::make('user.name')
                            ->label('Користувач')
                            ->placeholder('Система'),
                    ])
                    ->columnSpanFull(),

                Section::make('Час виконання')
                    ->icon(Heroicon::OutlinedClock)
                    ->schema([
                        TextEntry::make('started_at')
                            ->label('Початок')
                            ->dateTime()
                            ->placeholder('—'),
                        TextEntry::make('completed_at')
                            ->label('Завершення')
                            ->dateTime()
                            ->placeholder('—'),
                        TextEntry::make('created_at')
                            ->label('Створено')
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->label('Оновлено')
                            ->dateTime(),
                    ])
                    ->columnSpanFull(),

                Section::make('Помилка')
                    ->icon(Heroicon::OutlinedExclamationTriangle)
                    ->schema([
                        TextEntry::make('error_message')
                            ->label('Повідомлення про помилку')
                            ->columnSpanFull()
                            ->placeholder('—'),
                    ])
                    ->visible(fn (ImportLog $record): bool => $record->error_message !== null)
                    ->collapsible()
                    ->columnSpanFull(),

                Section::make('Метадані')
                    ->icon(Heroicon::OutlinedCodeBracket)
                    ->schema([
                        TextEntry::make('metadata')
                            ->label('Метадані')
                            ->formatStateUsing(fn ($state): string => json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) ?: '—')
                            ->columnSpanFull(),
                    ])
                    ->visible(fn (ImportLog $record): bool => ! empty($record->metadata))
                    ->collapsible()
                    ->columnSpanFull(),
            ]);
    }
}
