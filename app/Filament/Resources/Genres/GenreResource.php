<?php

namespace App\Filament\Resources\Genres;

use App\Filament\Resources\Genres\Pages\CreateGenre;
use App\Filament\Resources\Genres\Pages\EditGenre;
use App\Filament\Resources\Genres\Pages\ListGenres;
use App\Filament\Resources\Genres\Pages\ViewGenre;
use App\Filament\Resources\Genres\RelationManagers\AnimesRelationManager;
use App\Filament\Resources\Genres\Schemas\GenreForm;
use App\Filament\Resources\Genres\Schemas\GenreInfolist;
use App\Filament\Resources\Genres\Tables\GenresTable;
use App\Models\Genre;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class GenreResource extends Resource
{
    protected static ?string $model = Genre::class;
    protected static ?string $modelLabel = 'жанр';
    protected static string|UnitEnum|null $navigationGroup = 'Каталог';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;
    protected static ?string $navigationLabel = 'Жанри';
    protected static ?int $navigationSort = 1;
    protected static ?string $pluralModelLabel = 'Жанри';

    public static function form(Schema $schema): Schema
    {
        return GenreForm::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGenres::route('/'),
            'create' => CreateGenre::route('/create'),
            'view' => ViewGenre::route('/{record}'),
            'edit' => EditGenre::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            AnimesRelationManager::class,
        ];
    }

    public static function infolist(Schema $schema): Schema
    {
        return GenreInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GenresTable::configure($table);
    }
}
