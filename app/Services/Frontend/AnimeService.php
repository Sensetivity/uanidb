<?php

namespace App\Services\Frontend;

use App\Enums\AnimeTypeEnum;
use App\Models\Anime;
use App\Models\Season;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AnimeService
{
    public function findBySlug(string $slug): Anime
    {
        /** @var Anime $anime */
        $anime = Anime::query()
            ->where('slug', $slug)
            ->with([
                'genres',
                'themes',
                'studios',
                'producers',
                'seasons',
                'titles',
                'media',
            ])
            ->withCount('episodes')
            ->firstOrFail();

        return $anime;
    }

    /**
     * @param  array{
     *     search?: string,
     *     types?: int[],
     *     statuses?: int[],
     *     genres?: int[],
     *     themes?: int[],
     *     yearFrom?: int|null,
     *     yearTo?: int|null,
     *     minScore?: float|null,
     *     sortBy?: string,
     *     sortDirection?: string,
     * }  $filters
     */
    public function getByFilters(array $filters, int $perPage = 24): LengthAwarePaginator
    {
        $sortBy = $filters['sortBy'] ?? 'popularity';
        $sortDirection = $filters['sortDirection'] ?? 'desc';

        return Anime::query()
            ->when($filters['search'] ?? null, fn ($q, $search) => $q->search($search))
            ->when($filters['types'] ?? [], fn ($q, $types) => $q->byType($types))
            ->when($filters['statuses'] ?? [], fn ($q, $statuses) => $q->byStatus($statuses))
            ->when($filters['genres'] ?? [], fn ($q, $genres) => $q->byGenres($genres))
            ->when($filters['themes'] ?? [], fn ($q, $themes) => $q->byThemes($themes))
            ->when(
                ($filters['yearFrom'] ?? null) || ($filters['yearTo'] ?? null),
                fn ($q) => $q->byYearRange($filters['yearFrom'] ?? null, $filters['yearTo'] ?? null),
            )
            ->when($filters['minScore'] ?? null, fn ($q, $score) => $q->byMinScore($score))
            ->with(['genres', 'studios', 'media'])
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPage);
    }

    /**
     * @return Collection<int, Anime>
     */
    public function getForSeason(Season $season, ?string $typeFilter = null): Collection
    {
        return $season->animes()
            ->when($typeFilter && $typeFilter !== 'all', fn ($q) => $q->where('type', AnimeTypeEnum::fromString($typeFilter)))
            ->with(['genres', 'studios', 'media'])
            ->orderByDesc('score')
            ->get();
    }

    public function getTopByCategory(string $category, int $perPage = 25): LengthAwarePaginator
    {
        $query = Anime::query()->with(['genres', 'studios', 'media']);

        return match ($category) {
            'popular' => $query->orderByDesc('popularity')->paginate($perPage),
            'movies' => $query->byType(AnimeTypeEnum::MOVIE)->whereNotNull('score')->orderByDesc('score')->paginate($perPage),
            'ova' => $query->byType(AnimeTypeEnum::OVA)->whereNotNull('score')->orderByDesc('score')->paginate($perPage),
            default => $query->whereNotNull('score')->orderByDesc('score')->paginate($perPage),
        };
    }

    /**
     * @return Collection<int, Anime>
     */
    public function getTrending(int $limit = 12): Collection
    {
        return Anime::query()
            ->whereNotNull('score')
            ->orderByDesc('popularity')
            ->with(['genres', 'studios', 'media'])
            ->limit($limit)
            ->get();
    }
}
