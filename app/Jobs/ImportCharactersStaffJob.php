<?php

namespace App\Jobs;

use App\Enums\ImportJobTypeEnum;
use App\Enums\ImportStatusEnum;
use App\Jobs\Middleware\JikanRateLimitMiddleware;
use App\Models\Anime;
use App\Models\ImportLog;
use App\Services\AnimeImport\AnimeImportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ImportCharactersStaffJob implements ShouldQueue
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
    ) {}

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
        $anime = Anime::query()->find($this->animeId);

        $importLog = ImportLog::query()->create([
            'job_type' => ImportJobTypeEnum::ImportCharactersStaff,
            'anime_id' => $anime?->id,
            'mal_id' => $anime?->mal_id,
            'status' => ImportStatusEnum::Pending,
        ]);

        $importLog->markAsRunning();

        try {
            Log::info("ImportCharactersStaffJob: Starting for anime ID {$this->animeId}.");

            if (! $anime) {
                Log::warning("ImportCharactersStaffJob: Anime ID {$this->animeId} not found.");
                $importLog->markAsCompleted();

                return;
            }

            $importService->importCharactersAndStaff($anime);

            Log::info("ImportCharactersStaffJob: Completed for '{$anime->title}' (ID: {$anime->id}).");

            $importLog->markAsCompleted();
        } catch (\Throwable $e) {
            Log::error("ImportCharactersStaffJob: Failed for anime ID {$this->animeId}: {$e->getMessage()}");
            $importLog->markAsFailed($e->getMessage());

            throw $e;
        }
    }

    /**
     * @return array<int, object>
     */
    public function middleware(): array
    {
        return [new JikanRateLimitMiddleware()];
    }
}
