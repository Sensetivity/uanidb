<?php

namespace App\Jobs;

use App\Services\AnimeImport\AnimeImportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class ImportAnimeJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly int $malId,
        private readonly bool $forceUpdate = false,
        private readonly bool $downloadImages = false,
        private readonly bool $translate = false,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(AnimeImportService $importService): void
    {
        Log::info("ImportAnimeJob: Starting import for MAL ID {$this->malId}.");

        $anime = $importService->importBaseAnimeByMalId($this->malId, $this->forceUpdate);

        if (!$anime) {
            Log::warning("ImportAnimeJob: Anime MAL ID {$this->malId} not found on API.");

            return;
        }

        $jobs = [
            new ImportEpisodesJob($anime->id),
            new ImportCharactersStaffJob($anime->id),
            new ImportVideosJob($anime->id),
        ];

        if ($this->downloadImages) {
            $jobs[] = new DownloadAnimeImagesJob($anime->id);
        }

        if ($this->translate) {
            $jobs[] = new TranslateAnimeJob($anime->id);
        }

        $jobNames = array_map(fn ($j) => class_basename($j), $jobs);
        Log::info("ImportAnimeJob: Dispatching chain [" . implode(' → ', $jobNames) . "] for '{$anime->title}'.");

        Bus::chain($jobs)->dispatch();

        Log::info("ImportAnimeJob: Completed base import for '{$anime->title}' (MAL ID: {$this->malId}), chain dispatched.");
    }
}
