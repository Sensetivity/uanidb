<?php

namespace App\Console\Commands;

use App\Models\Anime;
use App\Services\TitleImport\TitleImportService;
use Illuminate\Console\Command;

class ImportAniDbTitlesCommand extends Command
{
    protected $signature = 'anidb:import-titles
                            {malId? : MAL ID of a specific anime}
                            {--all : Import titles for all anime with an anidb_id}
                            {--force : Overwrite existing Ukrainian titles}';

    protected $description = 'Import Ukrainian anime titles from AniDB title dump';

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

            $count = $service->importAnime($anime, $force);
            $this->info("Imported {$count} title(s) for: {$anime->title}");

            return self::SUCCESS;
        }

        $total = 0;
        $processed = 0;

        Anime::query()->whereNotNull('anidb_id')->chunk(100, function ($animes) use ($service, $force, &$total, &$processed): void {
            foreach ($animes as $anime) {
                $count = $service->importAnime($anime, $force);
                $total += $count;
                $processed++;

                if ($count > 0) {
                    $this->line("  [{$anime->mal_id}] {$anime->title}: +{$count} title(s)");
                }
            }
        });

        $this->info("Done. Processed {$processed} anime, imported {$total} title(s) total.");

        return self::SUCCESS;
    }
}
