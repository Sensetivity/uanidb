<?php

namespace App\Filament\Resources\People\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PersonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('mal_id')
                    ->label('MAL ID')
                    ->numeric(),
                TextInput::make('name')
                    ->label("Ім'я")
                    ->required()
                    ->maxLength(255),
                TextInput::make('japanese_name')
                    ->label("Японське ім'я")
                    ->maxLength(255),
                DatePicker::make('birth_date')
                    ->label('Дата народження'),
                Textarea::make('about')
                    ->label('Біографія')
                    ->rows(4)
                    ->columnSpanFull(),
                TextInput::make('source_image_url')
                    ->label('URL джерела зображення')
                    ->url()
                    ->maxLength(500)
                    ->columnSpanFull(),
                Section::make('Зображення')
                    ->schema([
                        FileUpload::make('main_image_upload')
                            ->label('Головне зображення')
                            ->image()
                            ->imageEditor()
                            ->directory('person-images')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->columnSpanFull()
                            ->dehydrated(false),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull(),
            ]);
    }
}
