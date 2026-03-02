<?php

namespace App\Enums;

enum MalEntryTypeEnum: string
{
    case Anime = 'anime';
    case Doujin = 'doujin';
    case LightNovel = 'light_novel';
    case Manga = 'manga';
    case Manhua = 'manhua';
    case Manhwa = 'manhwa';
    case Novel = 'novel';
    case OneShot = 'one-shot';
}
