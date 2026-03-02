<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ThemeType: int implements HasColor, HasLabel
{
    /**
     * Демографічна група (Дорослі персонажі)
     */
    case Demographic = 3;

    /**
     * Специфічний елемент контенту (Меха, Супер сили, Гарем)
     */
    case Element = 2;

    /**
     * Невизначений або загальний тип, який не підходить до інших категорій
     */
    case NonClassified = 5;

    /**
     * Середовище або місце дії
     */
    case Setting = 1;

    /**
     * Тематичний фокус контенту (Психологічний, Виживання)
     */
    case Theme = 4;

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Setting => 'info',
            self::Element => 'purple',
            self::Demographic => 'success',
            self::Theme => 'warning',
            self::NonClassified => 'gray',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::Setting => 'Середовище',
            self::Element => 'Елемент',
            self::Demographic => 'Демографія',
            self::Theme => 'Тема',
            self::NonClassified => 'Без категорії',
        };
    }
}
