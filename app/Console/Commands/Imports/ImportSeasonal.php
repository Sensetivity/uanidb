<?php

namespace App\Console\Commands\Imports;

use App\Services\AnimeImport\AnimeImportService;
use Illuminate\Console\Command;

class ImportSeasonal extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import seasonal anime from MAL';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:seasonal
        {year : Year (e.g. 2024)}
        {season : Season name (winter, spring, summer, fall)}
        {--pages=1 : Number of pages to import}
        {--force : Force update even if anime exists}';

    /**
     * Execute the console command.
     */
    public function handle(AnimeImportService $importService): int
    {
        $year = (int) $this->argument('year');
        $season = $this->argument('season');
        $pages = (int) $this->option('pages');
        $force = $this->option('force');

        $this->info("Importing {$season} {$year} anime ({$pages} page(s))...");

        try {
            $results = $importService->importSeasonalAnime($year, $season, $pages, $force);

            $this->info('Successfully imported ' . count($results) . ' anime.');

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Import failed: {$e->getMessage()}");

            return self::FAILURE;
        }
    }
}
