<?php

namespace App\Filament\Resources\Animes;

use App\Filament\Resources\Animes\Pages\CreateAnime;
use App\Filament\Resources\Animes\Pages\EditAnime;
use App\Filament\Resources\Animes\Pages\ListAnimes;
use App\Filament\Resources\Animes\Pages\ViewAnime;
use App\Filament\Resources\Animes\RelationManagers\CharactersRelationManager;
use App\Filament\Resources\Animes\RelationManagers\EpisodesRelationManager;
use App\Filament\Resources\Animes\RelationManagers\ProducersRelationManager;
use App\Filament\Resources\Animes\RelationManagers\StudiosRelationManager;
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

class AnimeResource extends Resource
{
    protected static ?string $model = Anime::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTv;

    public static function form(Schema $schema): Schema
    {
        return AnimeForm::configure($schema);
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

    public static function getRelations(): array
    {
        return [
            StudiosRelationManager::class,
            ProducersRelationManager::class,
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
