<?php

namespace App\Enums;

enum EpisodeTypeEnum: int
{
    case REGULAR = 1;
    case RECAP = 2;
    case FILLER = 3;

    //     public static $_episode_types = [
    //        self::EPISODE_TYPE_MAIN => 'Звичайний',
    //        self::EPISODE_TYP_RECAP => 'Компіляція',
    //        self::EPISODE_TYP_FILLER => 'Філер',
    //    ];
}
