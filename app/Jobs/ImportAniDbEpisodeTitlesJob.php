<?php

namespace App\Jobs;

use App\Enums\ImportJobTypeEnum;
use App\Enums\ImportStatusEnum;
use App\Models\Anime;
use App\Models\Episode;
use App\Models\ImportLog;
use App\Services\TitleImport\TitleImportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ImportAniDbEpisodeTitlesJob implements ShouldQueue
{
    use Queueable;

    public int $timeout = 600;

    public function __construct(
        private readonly int $animeId,
        private readonly bool $force = false,
    ) {}

    public function handle(TitleImportService $service): void
    {
        $anime = Anime::query()->find($this->animeId);

        $importLog = ImportLog::query()->create([
            'job_type' => ImportJobTypeEnum::ImportAniDbEpisodeTitles,
            'anime_id' => $anime?->id,
            'mal_id' => $anime?->mal_id,
            'status' => ImportStatusEnum::Pending,
        ]);

        $importLog->markAsRunning();

        try {
            if (! $anime) {
                Log::warning("ImportAniDbEpisodeTitlesJob: Anime ID {$this->animeId} not found.");
                $importLog->markAsCompleted();

                return;
            }

            if (! $anime->anidb_id) {
                Log::warning("ImportAniDbEpisodeTitlesJob: Anime \"{$anime->title}\" has no anidb_id, skipping.");
                $importLog->markAsCompleted();

                return;
            }

            $totalEpisodes = Episode::query()->where('anime_id', $anime->id)->count();
            Log::info("ImportAniDbEpisodeTitlesJob: Starting for \"{$anime->title}\" (AniDB ID: {$anime->anidb_id}), {$totalEpisodes} episode(s).");

            $count = 0;

            Episode::query()
                ->where('anime_id', $anime->id)
                ->chunk(100, function ($episodes) use ($service, &$count): void {
                    foreach ($episodes as $episode) {
                        if ($service->importEpisode($episode, $this->force)) {
                            $count++;
                        }
                    }
                    Log::info("ImportAniDbEpisodeTitlesJob: Chunk done — {$count} imported so far.");
                });

            Log::info("ImportAniDbEpisodeTitlesJob: Completed — imported {$count}/{$totalEpisodes} episode title(s) for \"{$anime->title}\".");

            $importLog->markAsCompleted();
        } catch (\Throwable $e) {
            Log::error("ImportAniDbEpisodeTitlesJob: Failed for anime ID {$this->animeId}: {$e->getMessage()}");
            $importLog->markAsFailed($e->getMessage());

            throw $e;
        }
    }
}
