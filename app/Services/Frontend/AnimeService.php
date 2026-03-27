<?php

namespace App\Services\Frontend;

use App\Dto\AnimeFilterDto;
use App\Enums\AnimeTypeEnum;
use App\Enums\RankingCategoryEnum;
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
            ->firstOrFail();

        return $anime;
    }

    /**
     * @return LengthAwarePaginator<int, Anime>
     */
    public function getByFilters(AnimeFilterDto $filters, int $perPage = 24): LengthAwarePaginator
    {
        return Anime::query()
            ->when($filters->search, fn ($q, $search) => $q->search($search))
            ->when($filters->types, fn ($q, $types) => $q->byType($types))
            ->when($filters->statuses, fn ($q, $statuses) => $q->byStatus($statuses))
            ->when($filters->genres, fn ($q, $genres) => $q->byGenres($genres))
            ->when($filters->themes, fn ($q, $themes) => $q->byThemes($themes))
            ->when(
                $filters->yearFrom || $filters->yearTo,
                fn ($q) => $q->byYearRange($filters->yearFrom, $filters->yearTo),
            )
            ->when($filters->minScore, fn ($q, $score) => $q->byMinScore($score))
            ->with(['genres', 'studios', 'media'])
            ->orderBy($filters->sortBy, $filters->sortDirection)
            ->paginate($perPage);
    }

    /**
     * @return Collection<int, Anime>
     */
    public function getForSeason(Season $season, ?string $typeFilter = null): Collection
    {
        /** @var Collection<int, Anime> */
        return $season->animes()
            ->when($typeFilter && $typeFilter !== 'all', fn ($q) => $q->where('type', AnimeTypeEnum::fromString((string) $typeFilter)))
            ->with(['genres', 'studios', 'media'])
            ->orderByDesc('score')
            ->get();
    }

    /**
     * @return LengthAwarePaginator<int, Anime>
     */
    public function getTopByCategory(RankingCategoryEnum $category, int $perPage = 25): LengthAwarePaginator
    {
        $query = Anime::query()->with(['genres', 'studios', 'media']);

        return match ($category) {
            RankingCategoryEnum::Popular => $query->orderByDesc('popularity')->paginate($perPage),
            RankingCategoryEnum::Movies => $query->byType(AnimeTypeEnum::MOVIE)->whereNotNull('score')->orderByDesc('score')->paginate($perPage),
            RankingCategoryEnum::Ova => $query->byType(AnimeTypeEnum::OVA)->whereNotNull('score')->orderByDesc('score')->paginate($perPage),
            RankingCategoryEnum::Top => $query->whereNotNull('score')->orderByDesc('score')->paginate($perPage),
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
