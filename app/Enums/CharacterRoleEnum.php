<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum CharacterRoleEnum: int implements HasColor, HasLabel
{
    case Background = 3;
    case Main = 1;
    case Supporting = 2;

    private const MAP = [
        'main' => self::Main,
        'supporting' => self::Supporting,
        'background' => self::Background,
    ];

    public static function fromString(string $role): self
    {
        return self::MAP[strtolower($role)] ?? self::Supporting;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Main => 'success',
            self::Supporting => 'info',
            self::Background => 'gray',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::Main => 'Головний',
            self::Supporting => 'Другорядний',
            self::Background => 'Фоновий',
        };
    }
}
