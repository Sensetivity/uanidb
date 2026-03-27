<?php

namespace App\Services\Frontend;

use App\Enums\StudioSortEnum;
use App\Models\Studio;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class StudioService
{
    public function findBySlug(string $slug): Studio
    {
        /** @var Studio $studio */
        $studio = Studio::query()
            ->where('slug', $slug)
            ->with([
                'animes' => fn ($q) => $q->withPivot('is_main')->orderByDesc('score')->limit(20),
                'animes.media',
                'media',
            ])
            ->withCount('animes')
            ->firstOrFail();

        return $studio;
    }

    /**
     * @return LengthAwarePaginator<int, Studio>
     */
    public function getList(StudioSortEnum $sort = StudioSortEnum::AnimeCount, int $perPage = 24): LengthAwarePaginator
    {
        $query = Studio::query()
            ->withCount('animes')
            ->with([
                'media',
                'popularAnimes.media',
                'recentAnimes.media',
            ]);

        return match ($sort) {
            StudioSortEnum::AnimeCount => $query->orderByDesc('animes_count')->paginate($perPage),
            StudioSortEnum::Name => $query->orderBy('name')->paginate($perPage),
        };
    }
}
