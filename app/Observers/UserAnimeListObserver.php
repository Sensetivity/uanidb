<?php

namespace App\Observers;

use App\Enums\WatchlistStatusEnum;
use App\Models\UserAnimeList;

class UserAnimeListObserver
{
    public function created(UserAnimeList $userAnimeList): void
    {
        $this->boostPriorityIfActive($userAnimeList);
    }

    public function updated(UserAnimeList $userAnimeList): void
    {
        if ($userAnimeList->wasChanged('status')) {
            $this->boostPriorityIfActive($userAnimeList);
        }
    }

    private function boostPriorityIfActive(UserAnimeList $userAnimeList): void
    {
        if (in_array($userAnimeList->status, [WatchlistStatusEnum::WATCHING, WatchlistStatusEnum::PLAN_TO_WATCH])) {
            $userAnimeList->anime()->increment('sync_priority', 2);
        }
    }
}
