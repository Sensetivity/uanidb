<?php

namespace App\Jobs;

use App\Enums\ImportJobTypeEnum;
use App\Jobs\Concerns\TracksImportLog;
use App\Jobs\Middleware\JikanRateLimitMiddleware;
use App\Models\Anime;
use App\Services\AnimeImport\AnimeImportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ImportEpisodesJob implements ShouldQueue
{
    use Queueable;
    use TracksImportLog;

    public int $maxExceptions = 3;
    public int $tries = 5;

    public function __construct(
        private readonly int $animeId,
    ) {}

    /**
     * @return array<int>
     */
    public function backoff(): array
    {
        return [5, 15, 30, 60, 120];
    }

    public function handle(AnimeImportService $importService): void
    {
        $anime = Anime::query()->find($this->animeId);

        $this->runWithImportLog($anime, function ($importLog) use ($anime, $importService): void {
            if (! $anime = $this->resolveAnimeOrSkip($this->animeId, $importLog)) {
                return;
            }

            Log::info("ImportEpisodesJob: Starting for '{$anime->title}' (ID: {$anime->id}).");
            $importService->importEpisodes($anime);
            Log::info("ImportEpisodesJob: Completed for '{$anime->title}' (ID: {$anime->id}).");
        });
    }

    /**
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [new JikanRateLimitMiddleware()];
    }

    protected function jobType(): ImportJobTypeEnum
    {
        return ImportJobTypeEnum::ImportEpisodes;
    }
}
