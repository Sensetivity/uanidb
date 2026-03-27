<?php

namespace App\Enums;

enum CharacterSortEnum: string
{
    case Name = 'name';

    public function getLabel(): string
    {
        return match ($this) {
            self::Name => 'За алфавітом',
        };
    }
}
