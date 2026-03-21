<?php

namespace App\Services\Sync;

use App\Contracts\Services\Sync\PriorityCalculator;
use App\Enums\AnimeStatusEnum;
use App\Enums\ImportStatusEnum;
use App\Enums\WatchlistStatusEnum;
use App\Jobs\DownloadAnimeImagesJob;
use App\Jobs\ImportAnimeJob;
use App\Jobs\ImportCharactersStaffJob;
use App\Jobs\ImportEpisodesJob;
use App\Models\Anime;
use App\Models\ImportLog;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class DataSyncScheduler
{
    public function __construct(
        private readonly PriorityCalculator $calculator,
    ) {}

    /**
     * Determine which jobs to dispatch for the given anime.
     *
     * @return array<class-string>
     */
    public function determineSyncJobs(Anime $anime): array
    {
        $fullResyncDays = config('services.anime_import.sync.full_resync_days', 14);
        $airingResyncHours = config('services.anime_import.sync.airing_resync_hours', 6);

        $daysSinceSync = $anime->last_synced_at?->diffInDays(now());
        $hoursSinceSync = $anime->last_synced_at?->diffInHours(now());

        // Never synced or very stale → full import
        if ($anime->last_synced_at === null || $daysSinceSync >= $fullResyncDays) {
            return [ImportAnimeJob::class];
        }

        // Airing and stale enough → base refresh (chains episodes)
        if ($anime->status === AnimeStatusEnum::AIRING && $hoursSinceSync >= $airingResyncHours) {
            return [ImportAnimeJob::class];
        }

        // Not yet aired and moderately stale → base refresh only
        if ($anime->status === AnimeStatusEnum::NOT_YET_AIRED && $daysSinceSync >= 3) {
            return [ImportAnimeJob::class];
        }

        $jobs = [];

        // Missing episodes
        if ($anime->episodes_count === 0) {
            $jobs[] = ImportEpisodesJob::class;
        }

        // Missing characters
        if ($anime->characters_count === 0) {
            $jobs[] = ImportCharactersStaffJob::class;
        }

        // Missing media
        if (! $anime->hasMedia('main_poster')) {
            $jobs[] = DownloadAnimeImagesJob::class;
        }

        // Default → base import if nothing specific needed
        if (empty($jobs)) {
            $jobs[] = ImportAnimeJob::class;
        }

        return $jobs;
    }

    /**
     * Dispatch the appropriate sync jobs for an anime.
     */
    public function dispatchSyncForAnime(Anime $anime): void
    {
        $jobs = $this->determineSyncJobs($anime);

        foreach ($jobs as $jobClass) {
            match ($jobClass) { // @phpstan-ignore match.unhandled
                ImportAnimeJob::class => ImportAnimeJob::dispatch($anime->mal_id),
                ImportEpisodesJob::class => ImportEpisodesJob::dispatch($anime->id),
                ImportCharactersStaffJob::class => ImportCharactersStaffJob::dispatch($anime->id),
                DownloadAnimeImagesJob::class => DownloadAnimeImagesJob::dispatch($anime->id),
            };
        }
    }

    /**
     * Get the next batch of anime to sync, excluding currently-running and recently-synced.
     *
     * @return Collection<int, Anime>
     */
    public function getNextBatch(int $limit = 10): Collection
    {
        $minResyncMinutes = config('services.anime_import.sync.min_resync_minutes', 10);

        // Get IDs of anime with currently running imports
        $runningAnimeIds = ImportLog::query()
            ->where('status', ImportStatusEnum::Running)
            ->where('started_at', '>=', now()->subHour())
            ->whereNotNull('anime_id')
            ->pluck('anime_id');

        return Anime::query()
            ->needingSync()
            ->where(function ($query) use ($minResyncMinutes) {
                $query->whereNull('last_synced_at')
                    ->orWhere('last_synced_at', '<=', now()->subMinutes($minResyncMinutes));
            })
            ->whereNotIn('id', $runningAnimeIds)
            ->withCount(['episodes', 'characters'])
            ->limit($limit)
            ->get();
    }

    /**
     * Recalculate sync priorities for all anime.
     */
    public function recalculateAllPriorities(): int
    {
        $count = 0;

        // Get watchlist counts per anime (watching + plan_to_watch)
        $watchlistCounts = DB::table('user_anime_lists')
            ->whereIn('status', [WatchlistStatusEnum::WATCHING->value, WatchlistStatusEnum::PLAN_TO_WATCH->value])
            ->groupBy('anime_id')
            ->pluck(DB::raw('COUNT(*) as count'), 'anime_id');

        // Get anime IDs that have media
        $animeWithMedia = DB::table('media')
            ->where('model_type', (new Anime())->getMorphClass())
            ->where('collection_name', 'main_poster')
            ->pluck('model_id')
            ->flip();

        Anime::query()
            ->withCount(['episodes', 'characters'])
            ->chunk(500, function ($animes) use ($watchlistCounts, $animeWithMedia, &$count) {
                $updates = [];

                foreach ($animes as $anime) {
                    $watchCount = $watchlistCounts[$anime->id] ?? 0;
                    $hasMedia = $animeWithMedia->has($anime->id);

                    $priority = $this->calculator->calculate($anime, $watchCount, $hasMedia);

                    if ((float) $anime->sync_priority !== $priority) {
                        $updates[$anime->id] = $priority;
                    }

                    $count++;
                }

                $this->batchUpdatePriorities($updates);
            });

        return $count;
    }

    /**
     * Batch update sync_priority for multiple anime in a single query.
     *
     * @param  array<int, float>  $updates  Map of anime ID → new priority
     */
    private function batchUpdatePriorities(array $updates): void
    {
        if ($updates === []) {
            return;
        }

        $cases = [];
        $bindings = [];

        foreach ($updates as $id => $priority) {
            $cases[] = 'WHEN ? THEN ?';
            $bindings[] = $id;
            $bindings[] = $priority;
        }

        $ids = array_keys($updates);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $bindings = array_merge($bindings, $ids);

        DB::update(
            'UPDATE animes SET sync_priority = CASE id ' . implode(' ', $cases) . ' END WHERE id IN (' . $placeholders . ')',
            $bindings,
        );
    }
}
