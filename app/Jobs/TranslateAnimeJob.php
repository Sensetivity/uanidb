<?php

namespace App\Jobs;

use App\Enums\ImportJobTypeEnum;
use App\Jobs\Concerns\TracksImportLog;
use App\Models\Anime;
use App\Services\Translation\TranslationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class TranslateAnimeJob implements ShouldQueue
{
    use Queueable;
    use TracksImportLog;

    public int $maxExceptions = 2;
    public int $tries = 3;

    public function __construct(
        private readonly int $animeId,
        private readonly bool $withEpisodes = true,
    ) {}

    /**
     * @return array<int>
     */
    public function backoff(): array
    {
        return [10, 30, 60];
    }

    public function handle(TranslationService $translationService): void
    {
        $anime = Anime::query()->find($this->animeId);

        $this->runWithImportLog($anime, function ($importLog) use ($anime, $translationService): void {
            if (! $anime = $this->resolveAnimeOrSkip($this->animeId, $importLog)) {
                return;
            }

            $translationService->translateAnimeSynopsis($anime);
            Log::info("TranslateAnimeJob: Synopsis translated for \"{$anime->title}\".");

            if ($this->withEpisodes) {
                $episodes = $anime->episodes()
                    ->where(function ($q) {
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
                    })
                    ->get();

                $episodeCount = $episodes->count();
                Log::info("TranslateAnimeJob: Translating {$episodeCount} episode(s) for \"{$anime->title}\".");

                $translated = 0;
                /** @var \App\Models\Episode $episode */
                foreach ($episodes as $episode) {
                    try {
                        $translationService->translateEpisode($episode);
                        $translated++;
                    } catch (\Exception $e) {
                        Log::warning("TranslateAnimeJob: Failed episode {$episode->number} for \"{$anime->title}\": {$e->getMessage()}");
                    }
                }

                Log::info("TranslateAnimeJob: Episodes done — {$translated}/{$episodeCount} translated.");
            }

            Log::info("TranslateAnimeJob: Completed for '{$anime->title}' (ID: {$anime->id}).");
        });
    }

    protected function jobType(): ImportJobTypeEnum
    {
        return ImportJobTypeEnum::TranslateAnime;
    }
}
