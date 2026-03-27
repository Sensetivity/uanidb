<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchStudioLogos extends Command
{
    protected $description = 'Fetch studio logos from Jikan API and update studios.json';
    protected $signature = 'studios:fetch-logos
        {--delay=400 : Delay between requests in ms}
        {--skip-existing : Skip studios that already have source_logo_url}';

    public function handle(): int
    {
        $path = storage_path('app/dump/studios.json');

        if (! File::exists($path)) {
            $this->error('studios.json not found.');

            return self::FAILURE;
        }

        $studios = json_decode(File::get($path), true);
        $delay = (int) $this->option('delay');
        $skipExisting = (bool) $this->option('skip-existing');
        $updated = 0;
        $skipped = 0;
        $failed = 0;

        $bar = $this->output->createProgressBar(count($studios));
        $bar->start();

        foreach ($studios as &$studio) {
            if ($skipExisting && ! empty($studio['source_logo_url'])) {
                $skipped++;
                $bar->advance();

                continue;
            }

            $malId = (int) $studio['id'];

            try {
                usleep($delay * 1000);

                $response = Http::timeout(15)->get("https://api.jikan.moe/v4/producers/{$malId}");

                if ($response->successful()) {
                    $data = $response->json('data');
                    $imageUrl = $data['images']['jpg']['image_url'] ?? null;

                    if ($imageUrl && $imageUrl !== 'https://cdn.myanimelist.net/img/sp/icon/apple-touch-icon-256.png') {
                        $studio['source_logo_url'] = $imageUrl;
                        $updated++;
                    }
                } elseif ($response->status() === 429) {
                    $this->newLine();
                    $this->warn("Rate limited at MAL ID {$malId}, waiting 5s...");
                    sleep(5);
                    $bar->advance();

                    continue;
                } else {
                    $failed++;
                }
            } catch (\Exception $e) {
                $failed++;
                Log::warning("Failed to fetch logo for studio {$malId}: {$e->getMessage()}");
            }

            $bar->advance();
        }

        unset($studio);

        $bar->finish();
        $this->newLine(2);

        $json = json_encode(array_values($studios), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        File::put($path, $json ?: '[]');

        $this->info("Done: {$updated} logos fetched, {$skipped} skipped, {$failed} failed.");

        return self::SUCCESS;
    }
}
