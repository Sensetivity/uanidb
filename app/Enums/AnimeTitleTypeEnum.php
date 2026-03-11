<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AnimeTitleTypeEnum: int implements HasColor, HasLabel
{
    case Jikan    = 5;
    case Main     = 1;
    case Manual   = 6;
    case Official = 2;
    case Short    = 4;
    case Syn      = 3;

    public static function fromAniDbType(string $type): self
    {
        return match (strtolower($type)) {
            'main'     => self::Main,
            'official' => self::Official,
            'syn'      => self::Syn,
            'short'    => self::Short,
            default    => self::Syn,
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Main => 'success',
            self::Official => 'info',
            self::Syn => 'gray',
            self::Short => 'warning',
            self::Jikan => 'purple',
            self::Manual => 'danger',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::Main     => 'Main',
            self::Official => 'Official',
            self::Syn      => 'Synonym',
            self::Short    => 'Short',
            self::Jikan    => 'Jikan',
            self::Manual   => 'Manual',
        };
    }
}
