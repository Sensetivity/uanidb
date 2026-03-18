<?php

namespace App\Filament\Resources\Studios;

use App\Filament\Resources\Studios\Pages\CreateStudio;
use App\Filament\Resources\Studios\Pages\EditStudio;
use App\Filament\Resources\Studios\Pages\ListStudios;
use App\Filament\Resources\Studios\Pages\ViewStudio;
use App\Filament\Resources\Studios\RelationManagers\AnimesRelationManager;
use App\Filament\Resources\Studios\Schemas\StudioForm;
use App\Filament\Resources\Studios\Schemas\StudioInfolist;
use App\Filament\Resources\Studios\Tables\StudiosTable;
use App\Models\Studio;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class StudioResource extends Resource
{
    protected static ?string $model = Studio::class;
    protected static ?string $modelLabel = 'студія';
    protected static string|UnitEnum|null $navigationGroup = 'Каталог';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;
    protected static ?string $navigationLabel = 'Студії';
    protected static ?int $navigationSort = 3;
    protected static ?string $pluralModelLabel = 'Студії';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return StudioForm::configure($schema);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudios::route('/'),
            'create' => CreateStudio::route('/create'),
            'view' => ViewStudio::route('/{record}'),
            'edit' => EditStudio::route('/{record}/edit'),
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
        return StudioInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StudiosTable::configure($table);
    }
}
