<?php

namespace App\Enums;

enum WatchlistStatusEnum: int
{
    case WATCHING = 1;
    case COMPLETED = 2;
    case ON_HOLD = 3;
    case DROPPED = 4;
    case PLAN_TO_WATCH = 5;
}
