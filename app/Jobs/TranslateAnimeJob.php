<?php

namespace App\Jobs;

use App\Enums\ImportJobTypeEnum;
use App\Enums\ImportStatusEnum;
use App\Models\Anime;
use App\Models\ImportLog;
use App\Services\Translation\TranslationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TranslateAnimeJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $maxExceptions = 2;
    public int $tries = 3;

    /**
     * Create a new job instance.
     */
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

    /**
     * Execute the job.
     */
    public function handle(TranslationService $translationService): void
    {
        $anime = Anime::query()->find($this->animeId);

        $importLog = ImportLog::query()->create([
            'job_type' => ImportJobTypeEnum::TranslateAnime,
            'anime_id' => $anime?->id,
            'mal_id' => $anime?->mal_id,
            'status' => ImportStatusEnum::Pending,
        ]);

        $importLog->markAsRunning();

        try {
            Log::info("TranslateAnimeJob: Starting for anime ID {$this->animeId}.");

            if (! $anime) {
                Log::warning("TranslateAnimeJob: Anime ID {$this->animeId} not found.");
                $importLog->markAsCompleted();

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

            $importLog->markAsCompleted();
        } catch (\Throwable $e) {
            Log::error("TranslateAnimeJob: Failed for anime ID {$this->animeId}: {$e->getMessage()}");
            $importLog->markAsFailed($e->getMessage());

            throw $e;
        }
    }
}
