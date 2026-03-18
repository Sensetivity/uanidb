<?php

namespace App\Filament\Resources\Studios\Schemas;

use App\Models\Studio;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;

class StudioInfolist
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
                            ->state(fn (Studio $record): int => $record->animes()->count())
                            ->icon(Heroicon::OutlinedTv),
                        TextEntry::make('mal_id')
                            ->label('MAL ID'),
                    ]),

                Section::make('Деталі')
                    ->schema([
                        TextEntry::make('website')
                            ->label('Вебсайт')
                            ->url(fn (?string $state): ?string => $state)
                            ->openUrlInNewTab()
                            ->placeholder('—'),
                        TextEntry::make('about')
                            ->label('Опис')
                            ->markdown()
                            ->prose()
                            ->columnSpanFull()
                            ->placeholder('—'),
                    ])
                    ->collapsible(),
            ]);
    }
}
