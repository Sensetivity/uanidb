<?php

namespace App\Contracts\Services\Sync;

use App\Models\Anime;

interface PriorityCalculator
{
    /**
     * Calculate sync priority score for an anime.
     *
     * @param  int  $watchlistCount  Number of users watching or planning to watch
     * @param  bool  $hasMedia  Whether the anime has media library images
     */
    public function calculate(Anime $anime, int $watchlistCount = 0, bool $hasMedia = false): float;
}
