<?php

namespace App\Services\AnimeImport\Processors;

use App\Dto\AnimeFullDto;
use App\Models\Anime;
use App\Models\AnimeExternalLink;
use Illuminate\Support\Facades\Log;

class ExternalLinkProcessor implements RelationProcessor
{
    public function sync(Anime $anime, AnimeFullDto $dto): void
    {
        if (empty($dto->anime->externalLinks)) {
            return;
        }

        $rows = [];
        $anidbId = null;

        foreach ($dto->anime->externalLinks as $link) {
            $rows[] = [
                'anime_id'   => $anime->id,
                'name'       => $link->name,
                'url'        => $link->url,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if ($anidbId === null && preg_match('/anidb\.net(?:\/anime\/|.*[?&]aid=)(\d+)/i', $link->url, $matches)) {
                $anidbId = (int) $matches[1];
            }
        }

        AnimeExternalLink::query()->insert($rows);

        if ($anidbId !== null) {
            $takenByOther = Anime::query()
                ->where('anidb_id', $anidbId)
                ->where('id', '!=', $anime->id)
                ->exists();

            if ($takenByOther) {
                Log::warning("ExternalLinkProcessor: anidb_id {$anidbId} already belongs to another anime, skipping for anime ID {$anime->id}.");
            } else {
                $anime->update(['anidb_id' => $anidbId]);
            }
        }
    }

    public function clear(Anime $anime): void
    {
        $anime->externalLinks()->delete();
    }
}
