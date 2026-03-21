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
    public function byGenres(array $genreIds): self
    {
        return $this->when($genreIds, fn (self $q) => $q->whereHas(
            'genres',
            fn (Builder $sub) => $sub->whereIn('genres.id', $genreIds),
        ));
    }

    public function byMinScore(float $minScore): self
    {
        return $this->where('score', '>=', $minScore);
    }

    public function byStatus(array|AnimeStatusEnum $statuses): self
    {
        $statuses = is_array($statuses) ? $statuses : [$statuses];

        return $this->when($statuses, fn (self $q) => $q->whereIn('status', $statuses));
    }

    public function byThemes(array $themeIds): self
    {
        return $this->when($themeIds, fn (self $q) => $q->whereHas(
            'themes',
            fn (Builder $sub) => $sub->whereIn('themes.id', $themeIds),
        ));
    }

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
