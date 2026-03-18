<?php

namespace App\Filament\Widgets;

use App\Enums\AnimeStatusEnum;
use App\Enums\AnimeTypeEnum;
use App\Filament\Resources\Animes\AnimeResource;
use App\Models\Anime;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentlyImportedAnime extends TableWidget
{
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'Нещодавно імпортовано';
    protected static ?int $sort = 6;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Anime::query()
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('title')
                    ->label('Назва')
                    ->limit(50)
                    ->searchable()
                    ->url(fn (Anime $record): string => AnimeResource::getUrl('view', ['record' => $record])),
                TextColumn::make('type')
                    ->label('Тип')
                    ->badge(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge(),
                TextColumn::make('mal_id')
                    ->label('MAL ID'),
                TextColumn::make('created_at')
                    ->label('Додано')
                    ->since(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Тип')
                    ->options(AnimeTypeEnum::class),
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options(AnimeStatusEnum::class),
            ])
            ->paginated(false);
    }
}
