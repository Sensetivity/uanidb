<?php

namespace App\Filament\Resources\Seasons\Schemas;

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
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('year')
                    ->numeric()
                    ->required(),
                Select::make('season_of_year')
                    ->options([
                        'Winter' => 'Winter',
                        'Spring' => 'Spring',
                        'Summer' => 'Summer',
                        'Fall' => 'Fall',
                    ])
                    ->required(),
                DatePicker::make('start_date'),
                DatePicker::make('end_date'),
                Toggle::make('is_current'),
            ]);
    }
}
