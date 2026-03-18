<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ImportJobTypeEnum: int implements HasColor, HasLabel
{
    case DownloadImages = 5;
    case ImportAniDbEpisodeTitles = 8;
    case ImportAniDbTitles = 7;
    case ImportAnime = 1;
    case ImportCharactersStaff = 3;
    case ImportEpisodes = 2;
    case ImportVideos = 4;
    case TranslateAnime = 6;

    public function getColor(): string
    {
        return match ($this) {
            self::ImportAnime => 'primary',
            self::ImportEpisodes => 'info',
            self::ImportCharactersStaff => 'warning',
            self::ImportVideos => 'success',
            self::DownloadImages => 'danger',
            self::TranslateAnime => 'purple',
            self::ImportAniDbTitles => 'cyan',
            self::ImportAniDbEpisodeTitles => 'orange',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::ImportAnime => 'Імпорт аніме',
            self::ImportEpisodes => 'Імпорт епізодів',
            self::ImportCharactersStaff => 'Імпорт персонажів і персоналу',
            self::ImportVideos => 'Імпорт відео',
            self::DownloadImages => 'Завантаження зображень',
            self::TranslateAnime => 'Переклад аніме',
            self::ImportAniDbTitles => 'Імпорт назв AniDB',
            self::ImportAniDbEpisodeTitles => 'Імпорт назв епізодів AniDB',
        };
    }
}
