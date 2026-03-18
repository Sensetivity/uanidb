<?php

namespace App\Filament\Resources\Genres\Schemas;

use App\Models\Genre;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;

class GenreInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->hiddenLabel()
                    ->size(TextSize::Large)
                    ->weight(FontWeight::Bold),

                Grid::make(3)
                    ->schema([
                        TextEntry::make('animes_count')
                            ->label('Аніме')
                            ->state(fn (Genre $record): int => $record->animes()->count())
                            ->icon(Heroicon::OutlinedTv),
                        TextEntry::make('created_at')
                            ->label('Створено')
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->label('Оновлено')
                            ->dateTime(),
                    ]),
            ]);
    }
}
