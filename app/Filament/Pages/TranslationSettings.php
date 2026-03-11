<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class TranslationSettings extends Page
{
    use InteractsWithSchemas;

    /** @var array<string, mixed> */
    public array $data = [];

    protected static string|UnitEnum|null $navigationGroup = 'Налаштування';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;
    protected static ?string $navigationLabel = 'Translation Settings';
    protected static ?string $title = 'Translation Settings';
    protected string $view = 'filament.pages.translation-settings';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('DeepL')
                    ->schema([
                        Select::make('translation_provider')
                            ->label('Translation Provider')
                            ->options(['deepl' => 'DeepL'])
                            ->required(),
                        TextInput::make('target_language')
                            ->label('Target Language')
                            ->default('UK')
                            ->required(),
                    ]),
                Section::make('AniDB')
                    ->schema([
                        TextInput::make('anidb_client')
                            ->label('AniDB Client Name')
                            ->helperText('Registered AniDB client name (for episode API)'),
                        TextInput::make('anidb_client_ver')
                            ->label('AniDB Client Version')
                            ->default('1'),
                    ]),
            ])
            ->statePath('data');
    }

    public function mount(): void
    {
        $this->getSchema('form')->fill([
            'translation_provider' => Setting::get('translation_provider', 'deepl'),
            'target_language'      => Setting::get('target_language', 'UK'),
            'anidb_client'         => Setting::get('anidb_client', ''),
            'anidb_client_ver'     => Setting::get('anidb_client_ver', '1'),
        ]);
    }

    public function save(): void
    {
        $data = $this->getSchema('form')->getState();

        Setting::set('translation_provider', $data['translation_provider']);
        Setting::set('target_language', $data['target_language']);
        Setting::set('anidb_client', $data['anidb_client'] ?? '');
        Setting::set('anidb_client_ver', $data['anidb_client_ver'] ?? '1');

        Notification::make()
            ->title('Налаштування збережено')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save')
                ->visible()
                ->action('save'),
        ];
    }
}
