<?php

namespace App\Enums;

enum WatchlistStatusEnum: int
{
    case COMPLETED = 2;
    case DROPPED = 4;
    case ON_HOLD = 3;
    case PLAN_TO_WATCH = 5;
    case WATCHING = 1;
}
