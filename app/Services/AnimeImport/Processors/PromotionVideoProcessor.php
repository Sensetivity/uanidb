<?php

namespace App\Services\AnimeImport\Processors;

use App\Dto\AnimeFullDto;
use App\Models\Anime;
use App\Models\PromotionVideo;

class PromotionVideoProcessor implements RelationProcessor
{
    public function clear(Anime $anime): void
    {
        $anime->promotionVideos()->delete();
    }

    public function sync(Anime $anime, AnimeFullDto $dto): void
    {
        foreach ($dto->promotionVideos as $videoDto) {
            PromotionVideo::query()->updateOrCreate(
                [
                    'anime_id' => $anime->id,
                    'video_url' => $videoDto->videoUrl,
                ],
                [
                    'title' => $videoDto->title,
                ],
            );
        }
    }
}
