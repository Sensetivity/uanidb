<?php

namespace App\Enums;

enum PromotionVideoTypeEnum: int
{
    case Trailer = 1;
    case Pv = 2;
    case Character = 3;
    case Opening = 4;
    case Ending = 5;
    case Other = 6;
}
