<?php

namespace App\Services\Frontend;

use App\Models\Character;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CharacterService
{
    public function findBySlug(string $slug): Character
    {
        /** @var Character $character */
        $character = Character::query()
            ->where('slug', $slug)
            ->with([
                'animes.media',
                'voiceActors.media',
                'media',
            ])
            ->firstOrFail();

        return $character;
    }

    /**
     * @return LengthAwarePaginator<int, Character>
     */
    public function getList(string $sortBy = 'name', int $perPage = 30): LengthAwarePaginator
    {
        return Character::query()
            ->withCount('animes')
            ->with('media')
            ->orderBy($sortBy)
            ->paginate($perPage);
    }
}
