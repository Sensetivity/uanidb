<?php

namespace App\Enums;

enum PersonSortEnum: string
{
    case Name = 'name';

    public function getLabel(): string
    {
        return match ($this) {
            self::Name => 'За алфавітом',
        };
    }
}
