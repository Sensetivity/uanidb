<?php

namespace App\Services\Sync;

use App\Contracts\Services\Sync\PriorityCalculator;
use App\Enums\AnimeStatusEnum;
use App\Models\Anime;

class SyncPriorityCalculator implements PriorityCalculator
{
    /**
     * Calculate sync priority score for an anime.
     *
     * @param  int  $watchlistCount  Number of users watching or planning to watch
     * @param  bool  $hasMedia  Whether the anime has media library images
     */
    public function calculate(Anime $anime, int $watchlistCount = 0, bool $hasMedia = false): float
    {
        $priority = 0.0;

        $priority += $this->airingUrgency($anime);
        $priority += $this->staleness($anime);
        $priority += $this->userDemand($watchlistCount);
        $priority += $this->notYetAiredBoost($anime);
        $priority += $this->dataCompleteness($anime, $hasMedia);
        $priority += $this->popularityTiebreaker($anime);
        $priority += $this->failurePenalty($anime);

        return max(0.0, round($priority, 2));
    }

    private function airingUrgency(Anime $anime): float
    {
        return $anime->status === AnimeStatusEnum::AIRING ? 50.0 : 0.0;
    }

    private function dataCompleteness(Anime $anime, bool $hasMedia): float
    {
        $score = 0.0;

        if ($anime->episodes_count === 0) {
            $score += 10.0;
        }

        if ($anime->characters_count === 0) {
            $score += 10.0;
        }

        if (! $hasMedia) {
            $score += 10.0;
        }

        if (empty($anime->synopsis)) {
            $score += 10.0;
        }

        return $score;
    }

    private function failurePenalty(Anime $anime): float
    {
        return max(-30.0, -$anime->failed_sync_count * 10.0);
    }

    private function notYetAiredBoost(Anime $anime): float
    {
        return $anime->status === AnimeStatusEnum::NOT_YET_AIRED ? 15.0 : 0.0;
    }

    private function popularityTiebreaker(Anime $anime): float
    {
        return min(($anime->score ?? 0) / 2, 5.0);
    }

    private function staleness(Anime $anime): float
    {
        if ($anime->last_synced_at === null) {
            return 40.0;
        }

        $daysSinceSync = $anime->last_synced_at->diffInDays(now());

        return min($daysSinceSync * 2, 40.0);
    }

    private function userDemand(int $watchlistCount): float
    {
        return min($watchlistCount * 2, 30.0);
    }
}
