<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ImportStatusEnum: int implements HasColor, HasLabel
{
    case Completed = 3;
    case Failed = 4;
    case Pending = 1;
    case Running = 2;

    public function getColor(): string
    {
        return match ($this) {
            self::Pending => 'gray',
            self::Running => 'info',
            self::Completed => 'success',
            self::Failed => 'danger',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'Очікує',
            self::Running => 'Виконується',
            self::Completed => 'Завершено',
            self::Failed => 'Помилка',
        };
    }
}
