<?php

namespace App\Filament\Resources\Seasons;

use App\Filament\Resources\Seasons\Pages\CreateSeason;
use App\Filament\Resources\Seasons\Pages\EditSeason;
use App\Filament\Resources\Seasons\Pages\ListSeasons;
use App\Filament\Resources\Seasons\Pages\ViewSeason;
use App\Filament\Resources\Seasons\RelationManagers\AnimesRelationManager;
use App\Filament\Resources\Seasons\Schemas\SeasonForm;
use App\Filament\Resources\Seasons\Schemas\SeasonInfolist;
use App\Filament\Resources\Seasons\Tables\SeasonsTable;
use App\Models\Season;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class SeasonResource extends Resource
{
    protected static ?string $model = Season::class;
    protected static ?string $modelLabel = 'сезон';
    protected static string|UnitEnum|null $navigationGroup = 'Каталог';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;
    protected static ?string $navigationLabel = 'Сезони';
    protected static ?int $navigationSort = 4;
    protected static ?string $pluralModelLabel = 'Сезони';

    public static function form(Schema $schema): Schema
    {
        return SeasonForm::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSeasons::route('/'),
            'create' => CreateSeason::route('/create'),
            'view' => ViewSeason::route('/{record}'),
            'edit' => EditSeason::route('/{record}/edit'),
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
        ];
    }

    public static function infolist(Schema $schema): Schema
    {
        return SeasonInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SeasonsTable::configure($table);
    }
}
