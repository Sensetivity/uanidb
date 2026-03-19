<?php

namespace App\Jobs;

use App\Enums\ImportJobTypeEnum;
use App\Jobs\Concerns\TracksImportLog;
use App\Services\AnimeImport\AnimeImportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class ImportAnimeJob implements ShouldQueue
{
    use Queueable;
    use TracksImportLog;

    public int $backoff = 30;
    public int $timeout = 120;
    public int $tries = 3;

    public function __construct(
        private readonly int $malId,
        private readonly bool $forceUpdate = false,
        private readonly bool $downloadImages = false,
        private readonly bool $translate = false,
    ) {}

    public function handle(AnimeImportService $importService): void
    {
        $this->runWithImportLog(null, function ($importLog) use ($importService): void {
            Log::info("ImportAnimeJob: Starting import for MAL ID {$this->malId}.");

            $anime = $importService->importBaseAnimeByMalId($this->malId, $this->forceUpdate);

            if (! $anime) {
                Log::warning("ImportAnimeJob: Anime MAL ID {$this->malId} not found on API.");

                return;
            }

            $importLog->update(['anime_id' => $anime->id]);

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

            $anime->markAsSynced();

            Log::info("ImportAnimeJob: Completed base import for '{$anime->title}' (MAL ID: {$this->malId}), chain dispatched.");
        }, $this->malId);
    }

    protected function jobType(): ImportJobTypeEnum
    {
        return ImportJobTypeEnum::ImportAnime;
    }
}
