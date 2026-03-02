<?php

namespace App\Dto;

use App\Enums\MalEntryTypeEnum;

readonly class RelatedAnimeEntryDto
{
    public function __construct(
        public int $malId,
        public MalEntryTypeEnum $type,
        public string $name,
    ) {}
}
