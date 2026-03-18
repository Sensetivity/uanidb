<?php

namespace App\Jobs;

use App\Enums\ImportJobTypeEnum;
use App\Enums\ImportStatusEnum;
use App\Models\ImportLog;
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
        $importLog = ImportLog::query()->create([
            'job_type' => ImportJobTypeEnum::ImportAnime,
            'mal_id' => $this->malId,
            'status' => ImportStatusEnum::Pending,
        ]);

        $importLog->markAsRunning();

        try {
            Log::info("ImportAnimeJob: Starting import for MAL ID {$this->malId}.");

            $anime = $importService->importBaseAnimeByMalId($this->malId, $this->forceUpdate);

            if (! $anime) {
                Log::warning("ImportAnimeJob: Anime MAL ID {$this->malId} not found on API.");
                $importLog->markAsCompleted();

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

            Log::info("ImportAnimeJob: Completed base import for '{$anime->title}' (MAL ID: {$this->malId}), chain dispatched.");

            $importLog->markAsCompleted();
        } catch (\Throwable $e) {
            Log::error("ImportAnimeJob: Failed for MAL ID {$this->malId}: {$e->getMessage()}");
            $importLog->markAsFailed($e->getMessage());

            throw $e;
        }
    }
}
