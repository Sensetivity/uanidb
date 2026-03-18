<?php

namespace App\Jobs;

use App\Enums\ImportJobTypeEnum;
use App\Jobs\Concerns\TracksImportLog;
use App\Models\Anime;
use App\Models\Episode;
use App\Services\TitleImport\TitleImportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ImportAniDbEpisodeTitlesJob implements ShouldQueue
{
    use Queueable;
    use TracksImportLog;

    public int $timeout = 600;

    public function __construct(
        private readonly int $animeId,
        private readonly bool $force = false,
    ) {}

    public function handle(TitleImportService $service): void
    {
        $anime = Anime::query()->find($this->animeId);

        $this->runWithImportLog($anime, function ($importLog) use ($anime, $service): void {
            if (! $anime = $this->resolveAnimeOrSkip($this->animeId, $importLog)) {
                return;
            }

            if (! $anime->anidb_id) {
                Log::warning("ImportAniDbEpisodeTitlesJob: Anime \"{$anime->title}\" has no anidb_id, skipping.");

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
        });
    }

    protected function jobType(): ImportJobTypeEnum
    {
        return ImportJobTypeEnum::ImportAniDbEpisodeTitles;
    }
}
