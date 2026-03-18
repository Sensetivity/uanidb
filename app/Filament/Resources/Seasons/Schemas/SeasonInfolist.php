<?php

namespace App\Filament\Resources\Seasons\Schemas;

use App\Models\Season;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class SeasonInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(4)
                    ->schema([
                        TextEntry::make('year')
                            ->label('Рік'),
                        TextEntry::make('season_of_year')
                            ->label('Пора року')
                            ->badge(),
                        IconEntry::make('is_current')
                            ->label('Поточний')
                            ->boolean(),
                        TextEntry::make('animes_count')
                            ->label('Аніме')
                            ->state(fn (Season $record): int => $record->animes()->count())
                            ->icon(Heroicon::OutlinedTv),
                    ]),

                Grid::make(2)
                    ->schema([
                        TextEntry::make('start_date')
                            ->label('Початок')
                            ->date('d.m.Y')
                            ->placeholder('—'),
                        TextEntry::make('end_date')
                            ->label('Кінець')
                            ->date('d.m.Y')
                            ->placeholder('—'),
                    ]),
            ]);
    }
}
