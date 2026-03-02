<?php

namespace App\Dto;

use App\Enums\AnimeRelationEnum;

readonly class RelatedAnimeGroupDto
{
    /**
     * @param array<RelatedAnimeEntryDto> $entries
     */
    public function __construct(
        public AnimeRelationEnum $relation,
        public array $entries,
    ) {}
}
