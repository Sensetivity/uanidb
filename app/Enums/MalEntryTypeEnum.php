<?php

namespace App\Enums;

enum MalEntryTypeEnum: string
{
    case Anime = 'anime';
    case Manga = 'manga';
    case LightNovel = 'light_novel';
    case OneShot = 'one-shot';
    case Doujin = 'doujin';
    case Manhwa = 'manhwa';
    case Manhua = 'manhua';
    case Novel = 'novel';
}
