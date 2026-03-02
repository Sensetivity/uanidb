<?php

namespace App\Jobs;

use App\Jobs\Middleware\JikanRateLimitMiddleware;
use App\Models\Anime;
use App\Services\AnimeImport\AnimeImportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportVideosJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $maxExceptions = 3;
    public int $tries = 5;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly int $animeId,
    ) {
    }

    /**
     * @return array<int>
     */
    public function backoff(): array
    {
        return [5, 15, 30, 60, 120];
    }

    /**
     * Execute the job.
     */
    public function handle(AnimeImportService $importService): void
    {
        Log::info("ImportVideosJob: Starting for anime ID {$this->animeId}.");

        $anime = Anime::find($this->animeId);

        if (! $anime) {
            Log::warning("ImportVideosJob: Anime ID {$this->animeId} not found.");

            return;
        }

        $importService->importPromotionVideos($anime);

        Log::info("ImportVideosJob: Completed for '{$anime->title}' (ID: {$anime->id}).");
    }

    /**
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [new JikanRateLimitMiddleware()];
    }
}
