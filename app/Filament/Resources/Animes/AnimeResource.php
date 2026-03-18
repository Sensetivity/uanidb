<?php

namespace App\Filament\Resources\Animes;

use App\Filament\Resources\Animes\Pages\CreateAnime;
use App\Filament\Resources\Animes\Pages\EditAnime;
use App\Filament\Resources\Animes\Pages\ListAnimes;
use App\Filament\Resources\Animes\Pages\ViewAnime;
use App\Filament\Resources\Animes\RelationManagers\CharactersRelationManager;
use App\Filament\Resources\Animes\RelationManagers\EpisodesRelationManager;
use App\Filament\Resources\Animes\RelationManagers\GenresRelationManager;
use App\Filament\Resources\Animes\RelationManagers\ProducersRelationManager;
use App\Filament\Resources\Animes\RelationManagers\StudiosRelationManager;
use App\Filament\Resources\Animes\RelationManagers\ThemesRelationManager;
use App\Filament\Resources\Animes\Schemas\AnimeForm;
use App\Filament\Resources\Animes\Schemas\AnimeInfolist;
use App\Filament\Resources\Animes\Tables\AnimesTable;
use App\Models\Anime;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class AnimeResource extends Resource
{
    protected static ?string $model = Anime::class;
    protected static ?string $modelLabel = 'аніме';
    protected static string|UnitEnum|null $navigationGroup = 'Контент';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTv;
    protected static ?string $navigationLabel = 'Аніме';
    protected static ?int $navigationSort = 1;
    protected static ?string $pluralModelLabel = 'Аніме';
    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return AnimeForm::configure($schema);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'mal_id'];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAnimes::route('/'),
            'create' => CreateAnime::route('/create'),
            'view' => ViewAnime::route('/{record}'),
            'edit' => EditAnime::route('/{record}/edit'),
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
            StudiosRelationManager::class,
            ProducersRelationManager::class,
            GenresRelationManager::class,
            ThemesRelationManager::class,
            EpisodesRelationManager::class,
            CharactersRelationManager::class,
        ];
    }

    public static function infolist(Schema $schema): Schema
    {
        return AnimeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AnimesTable::configure($table);
    }
}
