<?php

namespace App\Jobs;

use App\Enums\ImportJobTypeEnum;
use App\Jobs\Concerns\TracksImportLog;
use App\Models\Anime;
use App\Models\Person;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\HasMedia;

class DownloadAnimeImagesJob implements ShouldQueue
{
    use Queueable;
    use TracksImportLog;

    public int $timeout = 600;
    public int $tries = 3;

    public function __construct(
        private readonly int $animeId,
    ) {}

    /**
     * @return array<int>
     */
    public function backoff(): array
    {
        return [10, 30, 60];
    }

    public function handle(): void
    {
        $anime = Anime::query()->find($this->animeId);

        $this->runWithImportLog($anime, function ($importLog) use ($anime): void {
            if (! $anime = $this->resolveAnimeOrSkip($this->animeId, $importLog)) {
                return;
            }

            $delay = config('services.anime_import.image_download_delay');

            $characterCount = $anime->characters()->count();
            $personIds = $anime->people()->pluck('people.id')
                ->merge(DB::table('character_voice')->where('anime_id', $this->animeId)->pluck('person_id'))
                ->unique();

            Log::info("DownloadAnimeImagesJob: Processing poster + {$characterCount} character(s) + {$personIds->count()} person(s) for '{$anime->title}'.");

            $this->downloadImage($anime, $anime->image_url, 'main_poster');
            Log::info("DownloadAnimeImagesJob: Poster done for '{$anime->title}'.");

            $charactersDownloaded = 0;
            $anime->characters()->chunk(50, function ($characters) use ($delay, &$charactersDownloaded) {
                foreach ($characters as $character) {
                    usleep($delay * 1000);
                    $before = $character->hasMedia('main_image');
                    $this->downloadImage($character, $character->image_url, 'main_image');
                    if (! $before && $character->fresh()->hasMedia('main_image')) {
                        $charactersDownloaded++;
                    }
                }
            });
            Log::info("DownloadAnimeImagesJob: Characters done — {$charactersDownloaded}/{$characterCount} downloaded.");

            $peopleDownloaded = 0;
            Person::query()->whereIn('id', $personIds)->chunk(50, function ($people) use ($delay, &$peopleDownloaded) {
                foreach ($people as $person) {
                    usleep($delay * 1000);
                    $before = $person->hasMedia('main_image');
                    $this->downloadImage($person, $person->image_url, 'main_image');
                    if (! $before && $person->fresh()->hasMedia('main_image')) {
                        $peopleDownloaded++;
                    }
                }
            });
            Log::info("DownloadAnimeImagesJob: People done — {$peopleDownloaded}/{$personIds->count()} downloaded.");

            Log::info("DownloadAnimeImagesJob: Completed for '{$anime->title}' (ID: {$anime->id}).");
        });
    }

    protected function jobType(): ImportJobTypeEnum
    {
        return ImportJobTypeEnum::DownloadImages;
    }

    private function downloadImage(HasMedia $model, ?string $imageUrl, string $collection): void
    {
        if (! $imageUrl) {
            return;
        }

        if ($model->hasMedia($collection)) {
            return;
        }

        try {
            Log::info("DownloadAnimeImagesJob: Downloading image for {$model->getMorphClass()} ID {$model->getKey()}.");

            $model->addMediaFromUrl($imageUrl) // @phpstan-ignore method.notFound
                ->toMediaCollection($collection);
        } catch (\Exception $e) {
            Log::warning("DownloadAnimeImagesJob: Failed to download image for {$model->getMorphClass()} ID {$model->getKey()}: {$e->getMessage()}");
        }
    }
}
