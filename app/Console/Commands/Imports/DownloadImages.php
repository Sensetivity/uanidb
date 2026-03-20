<?php

namespace App\Console\Commands\Imports;

use App\Jobs\DownloadAnimeImagesJob;
use App\Models\Anime;
use Illuminate\Console\Command;

class DownloadImages extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download images for imported anime into media library';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:download-images
        {malId? : MAL ID of specific anime}
        {--all : Download images for all anime without media}
        {--chunk=50 : Chunk size for --all mode}';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $malId = $this->argument('malId');

        if ($malId) {
            return $this->downloadForAnime((int) $malId);
        }

        if ($this->option('all')) {
            return $this->downloadForAll();
        }

        $this->error('Please provide a MAL ID or use --all flag.');

        return self::FAILURE;
    }

    /**
     * Download images for all anime without media.
     */
    private function downloadForAll(): int
    {
        $chunk = (int) $this->option('chunk');

        $query = Anime::query()
            ->whereNotNull('source_image_url')
            ->whereDoesntHave('media', function ($q) {
                $q->where('collection_name', 'main_poster');
            });

        $total = $query->count();

        if ($total === 0) {
            $this->info('No anime found without images.');

            return self::SUCCESS;
        }

        $this->info("Dispatching image download jobs for {$total} anime...");
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $query->chunkById($chunk, function ($animes) use ($bar) {
            foreach ($animes as $anime) {
                DownloadAnimeImagesJob::dispatch($anime->id);
                $bar->advance();
            }
        });

        $bar->finish();
        $this->newLine();
        $this->info("Dispatched {$total} image download jobs.");

        return self::SUCCESS;
    }

    /**
     * Download images for a specific anime.
     */
    private function downloadForAnime(int $malId): int
    {
        $anime = Anime::query()->where('mal_id', $malId)->first();

        if (!$anime) {
            $this->error("Anime with MAL ID {$malId} not found.");

            return self::FAILURE;
        }

        DownloadAnimeImagesJob::dispatch($anime->id);
        $this->info("Dispatched image download job for: {$anime->title}");

        return self::SUCCESS;
    }
}
