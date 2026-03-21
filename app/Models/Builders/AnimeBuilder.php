<?php

namespace App\Models\Builders;

use App\Enums\AnimeStatusEnum;
use App\Enums\AnimeTypeEnum;
use App\Models\Anime;
use Illuminate\Database\Eloquent\Builder;

/**
 * @extends Builder<Anime>
 */
class AnimeBuilder extends Builder
{
    /**
     * Filter by genre slugs (lowercased mal_title) or IDs.
     *
     * @param  string[]|int[]  $genres
     */
    public function byGenres(array $genres): self
    {
        if (! $genres) {
            return $this;
        }

        $column = is_string($genres[0]) ? 'genres.mal_title' : 'genres.id';

        return $this->whereHas(
            'genres',
            fn (Builder $sub) => $sub->whereIn($column, is_string($genres[0])
                ? array_map(fn ($g) => ucfirst(strtolower((string) $g)), $genres)
                : $genres),
        );
    }

    public function byMinScore(float $minScore): self
    {
        return $this->where('score', '>=', $minScore);
    }

    /**
     * @param  array<int, AnimeStatusEnum>|AnimeStatusEnum  $statuses
     */
    public function byStatus(array|AnimeStatusEnum $statuses): self
    {
        $statuses = is_array($statuses) ? $statuses : [$statuses];

        return $this->when($statuses, fn (self $q) => $q->whereIn('status', $statuses));
    }

    /**
     * Filter by theme slugs (lowercased mal_title) or IDs.
     *
     * @param  string[]|int[]  $themes
     */
    public function byThemes(array $themes): self
    {
        if (! $themes) {
            return $this;
        }

        $column = is_string($themes[0]) ? 'themes.mal_title' : 'themes.id';

        return $this->whereHas(
            'themes',
            fn (Builder $sub) => $sub->whereIn($column, is_string($themes[0])
                ? array_map(fn ($t) => ucfirst(strtolower((string) $t)), $themes)
                : $themes),
        );
    }

    /**
     * @param  array<int, AnimeTypeEnum>|AnimeTypeEnum  $types
     */
    public function byType(array|AnimeTypeEnum $types): self
    {
        $types = is_array($types) ? $types : [$types];

        return $this->when($types, fn (self $q) => $q->whereIn('type', $types));
    }

    public function byYearRange(?int $from = null, ?int $to = null): self
    {
        return $this
            ->when($from, fn (self $q) => $q->whereYear('aired_from', '>=', $from))
            ->when($to, fn (self $q) => $q->whereYear('aired_from', '<=', $to));
    }

    public function needingSync(): self
    {
        return $this->where('sync_priority', '>', 0)->orderByDesc('sync_priority');
    }

    public function search(string $search): self
    {
        return $this->where('title', 'like', "%{$search}%");
    }
}
