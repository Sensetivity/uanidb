<?php

namespace App\Filament\Resources\ActivityLogs\Schemas;

use App\Filament\Resources\ActivityLogs\Tables\ActivityLogsTable;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Spatie\Activitylog\Models\Activity;

class ActivityLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Деталі події')
                    ->icon(Heroicon::OutlinedInformationCircle)
                    ->schema([
                        TextEntry::make('id')
                            ->label('ID'),
                        TextEntry::make('log_name')
                            ->label('Журнал')
                            ->placeholder('default'),
                        TextEntry::make('event')
                            ->label('Подія')
                            ->badge()
                            ->color(fn (?string $state): string => ActivityLogsTable::eventColor($state)),
                        TextEntry::make('description')
                            ->label('Опис'),
                        TextEntry::make('causer.name')
                            ->label('Користувач')
                            ->placeholder('Система'),
                        TextEntry::make('subject_type')
                            ->label('Тип моделі')
                            ->formatStateUsing(fn (?string $state): string => ActivityLogsTable::formatSubjectType($state)),
                        TextEntry::make('subject_id')
                            ->label('ID моделі')
                            ->placeholder('—'),
                        TextEntry::make('created_at')
                            ->label('Дата')
                            ->dateTime(),
                    ])
                    ->columnSpanFull(),

                Section::make('Нові значення')
                    ->icon(Heroicon::OutlinedDocumentPlus)
                    ->schema([
                        KeyValueEntry::make('properties.attributes')
                            ->hiddenLabel()
                            ->columnSpanFull(),
                    ])
                    ->visible(fn (Activity $record): bool => ! empty($record->properties->get('attributes')))
                    ->collapsible()
                    ->columnSpanFull(),

                Section::make('Старі значення')
                    ->icon(Heroicon::OutlinedDocumentMinus)
                    ->schema([
                        KeyValueEntry::make('properties.old')
                            ->hiddenLabel()
                            ->columnSpanFull(),
                    ])
                    ->visible(fn (Activity $record): bool => ! empty($record->properties->get('old')))
                    ->collapsible()
                    ->columnSpanFull(),
            ]);
    }
}
