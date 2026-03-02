<?php

namespace App\Enums;

enum PromotionVideoTypeEnum: int
{
    case Character = 3;
    case Ending = 5;
    case Opening = 4;
    case Other = 6;
    case Pv = 2;
    case Trailer = 1;
}
