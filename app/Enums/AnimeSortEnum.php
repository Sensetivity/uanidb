<?php

namespace App\Enums;

enum AnimeSortEnum: string
{
    case Newest = 'newest';
    case Popularity = 'popularity';
    case Score = 'score';
    case TitleAsc = 'title-asc';
    case TitleDesc = 'title-desc';

    public function column(): string
    {
        return match ($this) {
            self::Popularity => 'popularity',
            self::Score => 'score',
            self::Newest => 'aired_from',
            self::TitleAsc, self::TitleDesc => 'title',
        };
    }

    public function direction(): string
    {
        return match ($this) {
            self::TitleAsc => 'asc',
            default => 'desc',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::Popularity => 'Популярність',
            self::Score => 'Рейтинг',
            self::Newest => 'Новизна',
            self::TitleAsc => 'Назва (А-Я)',
            self::TitleDesc => 'Назва (Я-А)',
        };
    }
}
