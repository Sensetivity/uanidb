<?php

namespace App\Services\AnimeImport\Processors;

use App\Dto\AnimeFullDto;
use App\Models\Anime;

class TaxonomyProcessor implements RelationProcessor
{
    /**
     * @param string $relation Relationship name on Anime model (e.g. 'genres', 'themes')
     * @param class-string $modelClass Model class to firstOrCreate (e.g. Genre::class)
     * @param string $dtoProperty Property name on AnimeDto (e.g. 'genres', 'themes')
     */
    public function __construct(
        private readonly string $relation,
        private readonly string $modelClass,
        private readonly string $dtoProperty,
    ) {}

    public function clear(Anime $anime): void
    {
        $anime->{$this->relation}()->detach();
    }

    public function sync(Anime $anime, AnimeFullDto $dto): void
    {
        $terms = $dto->anime->{$this->dtoProperty};

        if (empty($terms)) {
            return;
        }

        $ids = [];

        foreach ($terms as $term) {
            $record = $this->modelClass::query()->firstOrCreate(
                ['mal_title' => $term->name],
                ['name' => $term->name],
            );

            $ids[] = $record->id;
        }

        if (! empty($ids)) {
            $anime->{$this->relation}()->sync($ids);
        }
    }
}
