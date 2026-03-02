<?php

namespace App\Services\AnimeImport\Processors;

use App\Dto\AnimeFullDto;
use App\Enums\AnimeTitleTypeEnum;
use App\Models\Anime;
use App\Models\AnimeTitle;

class TitleProcessor implements RelationProcessor
{
    public function clear(Anime $anime): void
    {
        $anime->titles()->delete();
    }

    public function sync(Anime $anime, AnimeFullDto $dto): void
    {
        if (empty($dto->anime->titles)) {
            return;
        }

        $titles = [];

        foreach ($dto->anime->titles as $titleData) {
            $titles[] = [
                'anime_id'   => $anime->id,
                'title'      => $titleData->title,
                'language'   => $titleData->language->toIsoCode(),
                'source'     => AnimeTitleTypeEnum::Jikan->value,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (empty($titles)) {
            return;
        }

        AnimeTitle::query()->insert($titles);
    }
}
