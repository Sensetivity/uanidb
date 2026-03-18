<?php

namespace App\Filament\Resources\Episodes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EpisodeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('anime.title')
                    ->label('Аніме'),
                TextEntry::make('number')
                    ->label('Номер'),
                TextEntry::make('type')
                    ->label('Тип')
                    ->badge(),
                TextEntry::make('title')
                    ->label('Назва (ромадзі)'),
                TextEntry::make('title_en')
                    ->label('Назва (EN)'),
                TextEntry::make('title_uk')
                    ->label('Назва (UK)'),
                TextEntry::make('title_ja')
                    ->label('Назва (JA)'),
                TextEntry::make('aired')
                    ->label('Дата виходу')
                    ->date(),
                TextEntry::make('duration')
                    ->label('Тривалість')
                    ->suffix(' хв'),
                TextEntry::make('synopsis')
                    ->label('Опис')
                    ->columnSpanFull(),
                TextEntry::make('synopsis_uk')
                    ->label('Опис (українською)')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->label('Створено')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->label('Оновлено')
                    ->dateTime(),
            ]);
    }
}
