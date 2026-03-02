<?php

namespace App\Console\Commands;

use App\Models\Anime;
use App\Models\Episode;
use App\Services\TitleImport\TitleImportService;
use Illuminate\Console\Command;

class ImportAniDbEpisodesCommand extends Command
{
    protected $signature = 'anidb:import-episodes
                            {malId? : MAL ID of a specific anime}
                            {--all : Import episode titles for all anime with an anidb_id}
                            {--force : Overwrite existing Ukrainian episode titles}';

    protected $description = 'Import Ukrainian episode titles from AniDB HTTP API';

    public function handle(TitleImportService $service): int
    {
        $malId = $this->argument('malId');
        $all = $this->option('all');
        $force = $this->option('force');

        if (! $malId && ! $all) {
            $this->error('Provide a malId argument or use --all flag.');

            return self::FAILURE;
        }

        if ($malId) {
            $anime = Anime::query()->where('mal_id', (int) $malId)->first();

            if (! $anime) {
                $this->error("Anime with MAL ID {$malId} not found.");

                return self::FAILURE;
            }

            if (! $anime->anidb_id) {
                $this->warn("Anime {$anime->title} has no anidb_id. Run anidb:sync-mapping first.");

                return self::FAILURE;
            }

            $count = $this->importEpisodesForAnime($service, $anime, $force);
            $this->info("Imported {$count} episode title(s) for: {$anime->title}");

            return self::SUCCESS;
        }

        $total = 0;
        $animeProcessed = 0;

        Anime::query()->whereNotNull('anidb_id')->chunk(50, function ($animes) use ($service, $force, &$total, &$animeProcessed): void {
            foreach ($animes as $anime) {
                $count = $this->importEpisodesForAnime($service, $anime, $force);

                if ($count > 0) {
                    $this->line("  [{$anime->mal_id}] {$anime->title}: +{$count} episode title(s)");
                }

                $total += $count;
                $animeProcessed++;
            }
        });

        $this->info("Done. Processed {$animeProcessed} anime, imported {$total} episode title(s) total.");

        return self::SUCCESS;
    }

    private function importEpisodesForAnime(TitleImportService $service, Anime $anime, bool $force): int
    {
        $count = 0;

        Episode::query()
            ->where('anime_id', $anime->id)
            ->chunk(100, function ($episodes) use ($service, $force, &$count): void {
                foreach ($episodes as $episode) {
                    if ($service->importEpisode($episode, $force)) {
                        $count++;
                    }
                }
            });

        return $count;
    }
}
