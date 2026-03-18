<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label("Ім'я")
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Ел. пошта')
                    ->email()
                    ->required()
                    ->unique()
                    ->maxLength(255),
                TextInput::make('password')
                    ->label('Пароль')
                    ->password()
                    ->required()
                    ->minLength(8)
                    ->maxLength(255)
                    ->dehydrateStateUsing(fn (string $state): string => bcrypt($state))
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),
                Toggle::make('is_admin')
                    ->label('Адмін'),
            ]);
    }
}
