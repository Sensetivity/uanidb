<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label("Ім'я"),
                TextEntry::make('email')
                    ->label('Ел. пошта'),
                IconEntry::make('is_admin')
                    ->label('Адмін')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->label('Створено')
                    ->dateTime(),
            ]);
    }
}
