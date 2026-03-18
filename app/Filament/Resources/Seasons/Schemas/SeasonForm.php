<?php

namespace App\Filament\Resources\Seasons\Schemas;

use App\Enums\SeasonOfYearEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SeasonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('year')
                    ->numeric()
                    ->required(),
                Select::make('season_of_year')
                    ->options(SeasonOfYearEnum::class)
                    ->required(),
                DatePicker::make('start_date'),
                DatePicker::make('end_date'),
                Toggle::make('is_current'),
            ]);
    }
}
