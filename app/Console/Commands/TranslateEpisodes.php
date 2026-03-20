<?php

namespace App\Console\Commands;

use App\Models\Anime;
use App\Models\Episode;
use App\Services\Translation\TranslationService;
use Illuminate\Console\Command;

class TranslateEpisodes extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Translate episode titles and synopses to Ukrainian via DeepL';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:episodes
        {animeId? : Translate episodes for a specific anime ID}
        {--untranslated : Only translate episodes without Ukrainian title/synopsis}';

    /**
     * Execute the console command.
     */
    public function handle(TranslationService $translationService): int
    {
        $animeId = $this->argument('animeId');

        $query = Episode::query();

        if ($animeId) {
            $anime = Anime::query()->find((int) $animeId);

            if (!$anime) {
                $this->error("Anime with ID {$animeId} not found.");

                return self::FAILURE;
            }

            $query->where('anime_id', $anime->id);
            $this->info("Translating episodes for: {$anime->title}");
        }

        if ($this->option('untranslated') || !$animeId) {
            $query->where(function ($q) {
                $q->where(function ($sub) {
                    $sub->whereNotNull('title_en')
                        ->where('title_en', '!=', '')
                        ->where(function ($s) {
                            $s->whereNull('title_uk')->orWhere('title_uk', '');
                        });
                })->orWhere(function ($sub) {
                    $sub->whereNotNull('synopsis')
                        ->where('synopsis', '!=', '')
                        ->where(function ($s) {
                            $s->whereNull('synopsis_uk')->orWhere('synopsis_uk', '');
                        });
                });
            });
        }

        $total = $query->count();

        if ($total === 0) {
            $this->info('No episodes to translate.');

            return self::SUCCESS;
        }

        $this->info("Translating {$total} episodes...");
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $translated = 0;
        $skipped = 0;
        $errors = 0;

        $query->chunkById(100, function ($episodes) use ($translationService, $bar, &$translated, &$skipped, &$errors) {
            foreach ($episodes as $episode) {
                try {
                    if ($translationService->translateEpisode($episode)) {
                        $translated++;
                    } else {
                        $skipped++;
                    }
                } catch (\Exception $e) {
                    $errors++;
                    $this->newLine();
                    $this->warn("Failed episode {$episode->anime_id} ep.{$episode->number}: {$e->getMessage()}");
                }

                $bar->advance();
            }
        });

        $bar->finish();
        $this->newLine(2);
        $this->info("Translation completed: {$translated} translated, {$skipped} skipped, {$errors} errors.");

        return self::SUCCESS;
    }
}
