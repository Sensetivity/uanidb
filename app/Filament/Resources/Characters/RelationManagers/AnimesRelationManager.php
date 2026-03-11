<?php

namespace App\Filament\Resources\Characters\RelationManagers;

use App\Enums\CharacterRoleEnum;
use App\Models\Anime;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AnimesRelationManager extends RelationManager
{
    protected static string $relationship = 'animes';
    protected static ?string $title = 'Аніме';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('role')
                    ->options(CharacterRoleEnum::class)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('media'))
            ->recordTitleAttribute('title')
            ->columns([
                ImageColumn::make('poster')
                    ->label('')
                    ->state(fn (Anime $record): ?string => $record->poster_url)
                    ->height(80)
                    ->width(56),
                TextColumn::make('title')
                    ->label('Назва')
                    ->searchable()
                    ->weight(FontWeight::Bold)
                    ->description(fn (Anime $record): string => implode(' | ', array_filter([
                        $record->type->getLabel(),
                        $record->episode_count ? "{$record->episode_count} еп." : null,
                        $record->aired_from?->format('Y'),
                    ]))),
                TextColumn::make('pivot.role')
                    ->label('Роль')
                    ->formatStateUsing(fn (int $state): CharacterRoleEnum => CharacterRoleEnum::from($state))
                    ->badge(),
                TextColumn::make('score')
                    ->label('Оцінка')
                    ->placeholder('—'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->schema(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Select::make('role')
                            ->options(CharacterRoleEnum::class)
                            ->required(),
                    ]),
            ])
            ->recordActions([
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
