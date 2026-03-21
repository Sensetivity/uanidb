<?php

namespace App\Services\Frontend;

use App\Models\Anime;
use App\Models\Character;
use App\Models\Person;
use App\Models\Season;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class HomeService
{
    public function getCurrentSeason(): ?Season
    {
        return Season::query()
            ->where('is_current', true)
            ->first();
    }

    /**
     * @return array{anime: int, characters: int, people: int, users: int}
     */
    public function getStats(): array
    {
        return [
            'anime' => Anime::query()->count(),
            'characters' => Character::query()->count(),
            'people' => Person::query()->count(),
            'users' => User::query()->count(),
        ];
    }

    /**
     * @return Collection<int, Anime>
     */
    public function getTrendingAnime(int $limit = 12): Collection
    {
        return Anime::query()
            ->whereNotNull('score')
            ->orderByDesc('popularity')
            ->with(['genres', 'studios', 'media'])
            ->limit($limit)
            ->get();
    }
}
