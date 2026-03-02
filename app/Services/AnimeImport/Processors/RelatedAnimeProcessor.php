<?php

namespace App\Services\AnimeImport\Processors;

use App\Dto\AnimeFullDto;
use App\Enums\AnimeStatusEnum;
use App\Enums\AnimeTypeEnum;
use App\Enums\MalEntryTypeEnum;
use App\Models\Anime;

class RelatedAnimeProcessor implements RelationProcessor
{
    public function clear(Anime $anime): void
    {
        $anime->relatedAnime()->detach();
    }

    public function sync(Anime $anime, AnimeFullDto $dto): void
    {
        if (empty($dto->anime->relatedAnime)) {
            return;
        }

        $pivotData = [];

        foreach ($dto->anime->relatedAnime as $relation) {
            foreach ($relation->entries as $entry) {
                if ($entry->type !== MalEntryTypeEnum::Anime) {
                    continue;
                }

                $relatedAnime = Anime::query()->firstOrCreate(
                    ['mal_id' => $entry->malId],
                    [
                        'title' => $entry->name,
                        'type' => AnimeTypeEnum::UNKNOWN,
                        'status' => AnimeStatusEnum::NOT_YET_AIRED,
                        'aired_unknown' => false,
                    ],
                );

                $pivotData[$relatedAnime->id] = [
                    'relation_type' => $relation->relation,
                ];
            }
        }

        if (! empty($pivotData)) {
            $anime->relatedAnime()->sync($pivotData);
        }
    }
}
