<?php

namespace App\Jobs;

use App\Enums\ImportJobTypeEnum;
use App\Enums\ImportStatusEnum;
use App\Models\Anime;
use App\Models\ImportLog;
use App\Services\TitleImport\TitleImportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ImportAniDbTitlesJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly int $animeId,
        private readonly bool $force = false,
    ) {}

    public function handle(TitleImportService $service): void
    {
        $anime = Anime::query()->find($this->animeId);

        $importLog = ImportLog::query()->create([
            'job_type' => ImportJobTypeEnum::ImportAniDbTitles,
            'anime_id' => $anime?->id,
            'mal_id' => $anime?->mal_id,
            'status' => ImportStatusEnum::Pending,
        ]);

        $importLog->markAsRunning();

        try {
            if (! $anime) {
                Log::warning("ImportAniDbTitlesJob: Anime ID {$this->animeId} not found.");
                $importLog->markAsCompleted();

                return;
            }

            if (! $anime->anidb_id) {
                Log::warning("ImportAniDbTitlesJob: Anime \"{$anime->title}\" has no anidb_id, skipping.");
                $importLog->markAsCompleted();

                return;
            }

            Log::info("ImportAniDbTitlesJob: Starting for \"{$anime->title}\" (AniDB ID: {$anime->anidb_id}).");

            $count = $service->importAnime($anime, $this->force);

            Log::info("ImportAniDbTitlesJob: Completed — imported {$count} title(s) for \"{$anime->title}\".");

            $importLog->markAsCompleted();
        } catch (\Throwable $e) {
            Log::error("ImportAniDbTitlesJob: Failed for anime ID {$this->animeId}: {$e->getMessage()}");
            $importLog->markAsFailed($e->getMessage());

            throw $e;
        }
    }
}
