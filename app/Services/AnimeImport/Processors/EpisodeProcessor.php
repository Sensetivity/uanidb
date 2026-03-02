<?php

namespace App\Services\AnimeImport\Processors;

use App\Dto\AnimeFullDto;
use App\Enums\EpisodeTypeEnum;
use App\Models\Anime;
use App\Models\Episode;

class EpisodeProcessor implements RelationProcessor
{
    public function clear(Anime $anime): void
    {
        $anime->episodes()->forceDelete();
    }

    public function sync(Anime $anime, AnimeFullDto $dto): void
    {
        foreach ($dto->episodes as $episodeDto) {
            $type = match (true) {
                $episodeDto->filler => EpisodeTypeEnum::Filler,
                $episodeDto->recap => EpisodeTypeEnum::Recap,
                default => EpisodeTypeEnum::Regular,
            };

            Episode::query()->updateOrCreate(
                [
                    'anime_id' => $anime->id,
                    'number' => $episodeDto->number,
                ],
                [
                    'mal_id' => $episodeDto->malId,
                    'title' => $episodeDto->titleRo ?? $episodeDto->title,
                    'title_ja' => $episodeDto->titleJa,
                    'title_en' => $episodeDto->title,
                    'aired' => $episodeDto->aired,
                    'duration' => $episodeDto->duration,
                    'type' => $type,
                ],
            );
        }
    }
}
