<?php

namespace App\Services\TitleImport;

use App\Contracts\Services\TitleImport\TitleImportProvider;
use App\Models\Anime;
use App\Models\AnimeTitle;
use App\Models\Episode;
use Illuminate\Support\Facades\Log;

class TitleImportService
{
    public function __construct(
        private readonly TitleImportProvider $provider,
    ) {}

    /**
     * Import Ukrainian anime titles from the provider.
     * Skips titles that already exist (same title text) unless $force is true.
     *
     * @return int Number of titles imported
     */
    public function importAnime(Anime $anime, bool $force = false): int
    {
        $titles = $this->provider->getAnimeUkTitles($anime);

        if (empty($titles)) {
            return 0;
        }

        $existingTitles = $anime->titles()
            ->where('language', 'uk')
            ->pluck('title')
            ->all();

        $imported = 0;

        foreach ($titles as $dto) {
            if (!$force && in_array($dto->title, $existingTitles, true)) {
                continue;
            }

            $record = AnimeTitle::query()->firstOrCreate(
                ['anime_id' => $anime->id, 'title' => $dto->title],
                ['language' => 'uk', 'source' => $dto->source],
            );

            if ($record->wasRecentlyCreated) {
                $existingTitles[] = $dto->title;
                $imported++;
            }
        }

        if ($imported > 0) {
            Log::info("Imported {$imported} Ukrainian title(s) for anime: {$anime->title} (ID: {$anime->id})");
        }

        return $imported;
    }

    /**
     * Import Ukrainian episode title from the provider.
     * Skips if already set unless $force is true.
     */
    public function importEpisode(Episode $episode, bool $force = false): bool
    {
        if (!$force && ! empty($episode->title_uk)) {
            return false;
        }

        $dto = $this->provider->getEpisodeUkTitle($episode);

        if ($dto === null) {
            return false;
        }

        $episode->update(['title_uk' => $dto->titleUk]);

        Log::info("Imported Ukrainian episode title for anime {$episode->anime_id} ep.{$episode->number}");

        return true;
    }
}
