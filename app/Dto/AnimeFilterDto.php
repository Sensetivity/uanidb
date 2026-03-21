<?php

namespace App\Dto;

use App\Enums\AnimeStatusEnum;
use App\Enums\AnimeTypeEnum;

readonly class AnimeFilterDto
{
    /**
     * @param  AnimeTypeEnum[]  $types
     * @param  AnimeStatusEnum[]  $statuses
     * @param  int[]  $genres
     * @param  int[]  $themes
     */
    public function __construct(
        public ?string $search = null,
        public array $types = [],
        public array $statuses = [],
        public array $genres = [],
        public array $themes = [],
        public ?int $yearFrom = null,
        public ?int $yearTo = null,
        public ?float $minScore = null,
        public string $sortBy = 'popularity',
        public string $sortDirection = 'desc',
    ) {}

    public function hasFilters(): bool
    {
        return $this->search !== null
            || $this->types !== []
            || $this->statuses !== []
            || $this->genres !== []
            || $this->themes !== []
            || $this->yearFrom !== null
            || $this->yearTo !== null
            || $this->minScore !== null;
    }
}
