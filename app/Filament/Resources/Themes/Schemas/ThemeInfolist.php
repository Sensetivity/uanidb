<?php

namespace App\Filament\Resources\Themes\Schemas;

use App\Models\Theme;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;

class ThemeInfolist
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
                        TextEntry::make('type')
                            ->label('Тип')
                            ->badge(),
                        TextEntry::make('animes_count')
                            ->label('Аніме')
                            ->state(fn (Theme $record): int => $record->animes()->count())
                            ->icon(Heroicon::OutlinedTv),
                    ]),

                TextEntry::make('description')
                    ->label('Опис')
                    ->columnSpanFull()
                    ->placeholder('—'),
            ]);
    }
}
