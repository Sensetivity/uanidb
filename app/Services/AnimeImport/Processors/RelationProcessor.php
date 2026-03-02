<?php

namespace App\Services\AnimeImport\Processors;

use App\Dto\AnimeFullDto;
use App\Models\Anime;

interface RelationProcessor
{
    /**
     * Clear all relation data for the anime model.
     */
    public function clear(Anime $anime): void;

    /**
     * Sync relation data from DTO to the anime model.
     */
    public function sync(Anime $anime, AnimeFullDto $dto): void;
}
