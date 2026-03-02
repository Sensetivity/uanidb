<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AnimeTitleTypeEnum: int implements HasLabel
{
    case Main     = 1;
    case Official = 2;
    case Syn      = 3;
    case Short    = 4;
    case Jikan    = 5;
    case Manual   = 6;

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
}
