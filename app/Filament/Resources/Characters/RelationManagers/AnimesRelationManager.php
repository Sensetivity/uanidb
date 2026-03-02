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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AnimesRelationManager extends RelationManager
{
    protected static string $relationship = 'animes';

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
            ->recordTitleAttribute('title')
            ->columns([
                ImageColumn::make('poster')
                    ->state(fn (Anime $record): ?string => $record->getFirstMediaUrl('main_poster') ?: $record->image_url)
                    ->height(60),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('pivot.role')
                    ->label('Role')
                    ->formatStateUsing(fn (int $state): CharacterRoleEnum => CharacterRoleEnum::from($state))
                    ->badge(),
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
