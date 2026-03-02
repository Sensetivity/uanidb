<?php

namespace App\Console\Commands;

use App\Models\Anime;
use App\Services\Translation\TranslationService;
use Illuminate\Console\Command;

class TranslateAnime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:anime
        {animeId? : Specific anime ID to translate}
        {--all : Translate all anime}
        {--untranslated : Only translate anime without Ukrainian synopsis}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Translate anime synopses to Ukrainian via DeepL';

    /**
     * Execute the console command.
     */
    public function handle(TranslationService $translationService): int
    {
        $animeId = $this->argument('animeId');

        if ($animeId) {
            return $this->translateSingle($translationService, (int) $animeId);
        }

        if (! $this->option('all') && ! $this->option('untranslated')) {
            $this->error('Please provide an anime ID, or use --all or --untranslated.');

            return self::FAILURE;
        }

        return $this->translateBatch($translationService);
    }

    /**
     * Translate a single anime synopsis.
     */
    private function translateSingle(TranslationService $translationService, int $animeId): int
    {
        $anime = Anime::query()->find($animeId);

        if (! $anime) {
            $this->error("Anime with ID {$animeId} not found.");

            return self::FAILURE;
        }

        if (empty($anime->synopsis)) {
            $this->warn("Anime \"{$anime->title}\" has no synopsis to translate.");

            return self::SUCCESS;
        }

        try {
            $translated = $translationService->translateAnimeSynopsis($anime);

            if ($translated) {
                $this->info("Translated synopsis for: {$anime->title}");
            } else {
                $this->info("Anime \"{$anime->title}\" already has a Ukrainian synopsis.");
            }

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Translation failed: {$e->getMessage()}");

            return self::FAILURE;
        }
    }

    /**
     * Translate anime synopses in batch.
     */
    private function translateBatch(TranslationService $translationService): int
    {
        $query = Anime::query()->whereNotNull('synopsis')->where('synopsis', '!=', '');

        if ($this->option('untranslated')) {
            $query->where(function ($q) {
                $q->whereNull('synopsis_uk')->orWhere('synopsis_uk', '');
            });
        }

        $total = $query->count();

        if ($total === 0) {
            $this->info('No anime to translate.');

            return self::SUCCESS;
        }

        $this->info("Translating {$total} anime synopses...");
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $translated = 0;
        $skipped = 0;
        $errors = 0;

        $query->chunkById(50, function ($animes) use ($translationService, $bar, &$translated, &$skipped, &$errors) {
            foreach ($animes as $anime) {
                try {
                    if ($translationService->translateAnimeSynopsis($anime)) {
                        $translated++;
                    } else {
                        $skipped++;
                    }
                } catch (\Exception $e) {
                    $errors++;
                    $this->newLine();
                    $this->warn("Failed to translate \"{$anime->title}\": {$e->getMessage()}");
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
