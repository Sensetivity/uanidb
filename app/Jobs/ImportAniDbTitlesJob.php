<?php

namespace App\Jobs;

use App\Models\Anime;
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

        if (!$anime) {
            Log::warning("ImportAniDbTitlesJob: Anime ID {$this->animeId} not found.");

            return;
        }

        if (!$anime->anidb_id) {
            Log::warning("ImportAniDbTitlesJob: Anime \"{$anime->title}\" has no anidb_id, skipping.");

            return;
        }

        Log::info("ImportAniDbTitlesJob: Starting for \"{$anime->title}\" (AniDB ID: {$anime->anidb_id}).");

        $count = $service->importAnime($anime, $this->force);

        Log::info("ImportAniDbTitlesJob: Completed — imported {$count} title(s) for \"{$anime->title}\".");
    }
}
