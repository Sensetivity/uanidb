<?php

namespace App\Filament\Resources\ImportLogs;

use App\Filament\Resources\ImportLogs\Pages\ListImportLogs;
use App\Filament\Resources\ImportLogs\Pages\ViewImportLog;
use App\Filament\Resources\ImportLogs\Schemas\ImportLogInfolist;
use App\Filament\Resources\ImportLogs\Tables\ImportLogsTable;
use App\Models\ImportLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ImportLogResource extends Resource
{
    protected static ?string $model = ImportLog::class;
    protected static ?string $modelLabel = 'журнал імпорту';
    protected static string|UnitEnum|null $navigationGroup = 'Адміністрування';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowDownTray;
    protected static ?string $navigationLabel = 'Журнал імпорту';
    protected static ?int $navigationSort = 98;
    protected static ?string $pluralModelLabel = 'Журнал імпорту';
    protected static ?string $slug = 'import-logs';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListImportLogs::route('/'),
            'view' => ViewImportLog::route('/{record}'),
        ];
    }

    public static function infolist(Schema $schema): Schema
    {
        return ImportLogInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ImportLogsTable::configure($table);
    }
}
