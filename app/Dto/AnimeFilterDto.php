<?php

namespace App\Dto;

use App\Enums\AnimeStatusEnum;
use App\Enums\AnimeTypeEnum;

readonly class AnimeFilterDto
{
    /**
     * @param  AnimeTypeEnum[]  $types
     * @param  AnimeStatusEnum[]  $statuses
     * @param  string[]  $genres  Genre slugs (lowercased mal_title)
     * @param  string[]  $themes  Theme slugs (lowercased mal_title)
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

    /**
     * Create from URL query parameters.
     *
     * Example: ?type=tv,movie&status=airing&genre=action,comedy&year=2024&score=8&sort=score
     *
     * @param  array<string, string|null>  $query
     */
    public static function fromQueryString(array $query): self
    {
        $types = [];
        foreach (self::splitComma($query['type'] ?? null) as $slug) {
            $enum = AnimeTypeEnum::fromSlug($slug);
            if ($enum) {
                $types[] = $enum;
            }
        }

        $statuses = [];
        foreach (self::splitComma($query['status'] ?? null) as $slug) {
            $enum = AnimeStatusEnum::fromSlug($slug);
            if ($enum) {
                $statuses[] = $enum;
            }
        }

        $sort = $query['sort'] ?? 'popularity';
        $sortDirection = 'desc';
        if (str_starts_with($sort, '-')) {
            $sort = substr($sort, 1);
            $sortDirection = 'asc';
        }

        return new self(
            search: $query['q'] ?? null,
            types: $types,
            statuses: $statuses,
            genres: self::splitComma($query['genre'] ?? null),
            themes: self::splitComma($query['theme'] ?? null),
            yearFrom: isset($query['year_from']) ? (int) $query['year_from'] : (isset($query['year']) ? (int) $query['year'] : null),
            yearTo: isset($query['year_to']) ? (int) $query['year_to'] : null,
            minScore: isset($query['score']) ? (float) $query['score'] : null,
            sortBy: $sort,
            sortDirection: $sortDirection,
        );
    }

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

    /**
     * Convert back to URL query parameters.
     *
     * @return array<string, string>
     */
    public function toQueryString(): array
    {
        $query = [];

        if ($this->search) {
            $query['q'] = $this->search;
        }

        if ($this->types) {
            $query['type'] = implode(',', array_map(fn (AnimeTypeEnum $t) => $t->slug(), $this->types));
        }

        if ($this->statuses) {
            $query['status'] = implode(',', array_map(fn (AnimeStatusEnum $s) => $s->slug(), $this->statuses));
        }

        if ($this->genres) {
            $query['genre'] = implode(',', $this->genres);
        }

        if ($this->themes) {
            $query['theme'] = implode(',', $this->themes);
        }

        if ($this->yearFrom) {
            $query['year_from'] = (string) $this->yearFrom;
        }

        if ($this->yearTo) {
            $query['year_to'] = (string) $this->yearTo;
        }

        if ($this->minScore) {
            $query['score'] = (string) $this->minScore;
        }

        $sortPrefix = $this->sortDirection === 'asc' ? '-' : '';
        if ($this->sortBy !== 'popularity' || $this->sortDirection !== 'desc') {
            $query['sort'] = $sortPrefix . $this->sortBy;
        }

        return $query;
    }

    /**
     * @return string[]
     */
    private static function splitComma(?string $value): array
    {
        if ($value === null || $value === '') {
            return [];
        }

        return array_filter(array_map('trim', explode(',', $value)));
    }
}
