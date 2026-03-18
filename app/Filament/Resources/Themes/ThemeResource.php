<?php

namespace App\Filament\Resources\Themes;

use App\Filament\Resources\Themes\Pages\CreateTheme;
use App\Filament\Resources\Themes\Pages\EditTheme;
use App\Filament\Resources\Themes\Pages\ListThemes;
use App\Filament\Resources\Themes\Pages\ViewTheme;
use App\Filament\Resources\Themes\RelationManagers\AnimesRelationManager;
use App\Filament\Resources\Themes\Schemas\ThemeForm;
use App\Filament\Resources\Themes\Schemas\ThemeInfolist;
use App\Filament\Resources\Themes\Tables\ThemesTable;
use App\Models\Theme;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ThemeResource extends Resource
{
    protected static ?string $model = Theme::class;
    protected static ?string $modelLabel = 'тема';
    protected static string|UnitEnum|null $navigationGroup = 'Каталог';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;
    protected static ?string $navigationLabel = 'Теми';
    protected static ?int $navigationSort = 2;
    protected static ?string $pluralModelLabel = 'Теми';

    public static function form(Schema $schema): Schema
    {
        return ThemeForm::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListThemes::route('/'),
            'create' => CreateTheme::route('/create'),
            'view' => ViewTheme::route('/{record}'),
            'edit' => EditTheme::route('/{record}/edit'),
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
        return ThemeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ThemesTable::configure($table);
    }
}
