<?php

namespace App\Enums;

enum CharacterRoleEnum: int
{
    case MAIN = 1;
    case SUPPORTING = 2;
    case BACKGROUND = 3;

    private const MAP = [
        'main' => self::MAIN,
        'supporting' => self::SUPPORTING,
        'background' => self::BACKGROUND,
    ];

    public static function fromString(string $role): self
    {
        return self::MAP[strtolower($role)] ?? self::SUPPORTING;
    }
}
