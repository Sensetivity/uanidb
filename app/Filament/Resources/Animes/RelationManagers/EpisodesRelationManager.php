<?php

namespace App\Filament\Resources\Animes\RelationManagers;

use App\Enums\EpisodeTypeEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EpisodesRelationManager extends RelationManager
{
    protected static string $relationship = 'episodes';
    protected static ?string $title = 'Епізоди';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('number')
                    ->label('Номер')
                    ->numeric()
                    ->required(),
                Select::make('type')
                    ->label('Тип')
                    ->options(EpisodeTypeEnum::class)
                    ->required(),
                TextInput::make('title')
                    ->label('Назва (Romaji)')
                    ->maxLength(255),
                TextInput::make('title_en')
                    ->label('Назва (EN)')
                    ->maxLength(255),
                TextInput::make('title_uk')
                    ->label('Назва (UK)')
                    ->maxLength(255),
                DatePicker::make('aired')
                    ->label('Дата виходу'),
                TextInput::make('duration')
                    ->label('Тривалість')
                    ->numeric()
                    ->suffix('хв.'),
                Textarea::make('synopsis')
                    ->label('Опис')
                    ->rows(3)
                    ->columnSpanFull(),
                Textarea::make('synopsis_uk')
                    ->label('Опис (UK)')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('number')
            ->defaultSort('number')
            ->columns([
                TextColumn::make('number')
                    ->label('#')
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Назва')
                    ->limit(40)
                    ->searchable()
                    ->description(fn ($record): ?string => $record->title_uk),
                TextColumn::make('aired')
                    ->label('Дата виходу')
                    ->date('d.m.Y')
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Тип')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
