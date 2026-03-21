<?php

namespace App\Services\Frontend;

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

    public function getList(string $sortBy = 'name', int $perPage = 24): LengthAwarePaginator
    {
        $query = Studio::query()->with('media');

        return match ($sortBy) {
            'anime_count' => $query->withCount('animes')->orderByDesc('animes_count')->paginate($perPage),
            default => $query->orderBy('name')->paginate($perPage),
        };
    }
}
