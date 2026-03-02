<?php

namespace App\Filament\Resources\Characters;

use App\Filament\Resources\Characters\Pages\CreateCharacter;
use App\Filament\Resources\Characters\Pages\EditCharacter;
use App\Filament\Resources\Characters\Pages\ListCharacters;
use App\Filament\Resources\Characters\Pages\ViewCharacter;
use App\Filament\Resources\Characters\RelationManagers\AnimesRelationManager;
use App\Filament\Resources\Characters\RelationManagers\VoiceActorsRelationManager;
use App\Filament\Resources\Characters\Schemas\CharacterForm;
use App\Filament\Resources\Characters\Schemas\CharacterInfolist;
use App\Filament\Resources\Characters\Tables\CharactersTable;
use App\Models\Character;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CharacterResource extends Resource
{
    protected static ?string $model = Character::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    public static function form(Schema $schema): Schema
    {
        return CharacterForm::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCharacters::route('/'),
            'create' => CreateCharacter::route('/create'),
            'view' => ViewCharacter::route('/{record}'),
            'edit' => EditCharacter::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AnimesRelationManager::class,
            VoiceActorsRelationManager::class,
        ];
    }

    public static function infolist(Schema $schema): Schema
    {
        return CharacterInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CharactersTable::configure($table);
    }
}
