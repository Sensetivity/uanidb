<?php

namespace App\Filament\Resources\Animes\RelationManagers;

use App\Enums\CharacterRoleEnum;
use App\Models\Character;
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

class CharactersRelationManager extends RelationManager
{
    protected static string $relationship = 'characters';
    protected static ?string $title = 'Персонажі';

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
            ->recordTitleAttribute('name')
            ->columns([
                ImageColumn::make('photo')
                    ->label('')
                    ->state(fn (Character $record): ?string => $record->getFirstMediaUrl('main_image') ?: $record->image_url)
                    ->height(60)
                    ->width(42),
                TextColumn::make('name')
                    ->label("Ім'я")
                    ->searchable()
                    ->weight('bold')
                    ->description(fn (Character $record): ?string => $record->japanese_name),
                TextColumn::make('pivot.role')
                    ->label('Роль')
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
