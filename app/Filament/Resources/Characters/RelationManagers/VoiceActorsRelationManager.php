<?php

namespace App\Filament\Resources\Characters\RelationManagers;

use App\Models\Anime;
use App\Models\Person;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VoiceActorsRelationManager extends RelationManager
{
    protected static string $relationship = 'voiceActors';
    protected static ?string $title = 'Сейю';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('anime_id')
                    ->label('Anime')
                    ->options(Anime::query()->pluck('title', 'id'))
                    ->searchable()
                    ->required(),
                TextInput::make('language')
                    ->required()
                    ->maxLength(10),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('media'))
            ->recordTitleAttribute('name')
            ->columns([
                ImageColumn::make('photo')
                    ->label('')
                    ->state(fn (Person $record): ?string => $record->image_display_url)
                    ->height(60)
                    ->width(45)
                    ->circular(false),
                TextColumn::make('name')
                    ->label("Ім'я")
                    ->searchable()
                    ->weight(FontWeight::Bold),
                TextColumn::make('pivot.language')
                    ->label('Мова')
                    ->badge()
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'japanese' => 'danger',
                        'english' => 'info',
                        'korean' => 'success',
                        'german' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('anime_title')
                    ->label('Аніме')
                    ->state(function (Person $record): string {
                        static $animeCache = [];

                        $animeId = $record->getRelationValue('pivot')?->getAttribute('anime_id');

                        if ($animeId === null) {
                            return '—';
                        }

                        if (! isset($animeCache[$animeId])) {
                            $animeCache[$animeId] = Anime::query()->find($animeId)->title ?? '—';
                        }

                        return $animeCache[$animeId];
                    }),
            ])
            ->filters([
                SelectFilter::make('language')
                    ->label('Мова')
                    ->options(function (): array {
                        /** @var \App\Models\Character $owner */
                        $owner = $this->getOwnerRecord();

                        return $owner->voiceActors()
                            ->select('character_voice.language')
                            ->distinct()
                            ->pluck('character_voice.language', 'character_voice.language')
                            ->toArray();
                    })
                    ->attribute('language'),
            ])
            ->headerActions([
                AttachAction::make()
                    ->preloadRecordSelect()
                    ->schema(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Select::make('anime_id')
                            ->label('Anime')
                            ->options(Anime::query()->pluck('title', 'id'))
                            ->searchable()
                            ->required(),
                        TextInput::make('language')
                            ->required()
                            ->maxLength(10),
                    ]),
            ])
            ->recordActions([
                DetachAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
