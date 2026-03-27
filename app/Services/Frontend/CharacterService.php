<?php

namespace App\Services\Frontend;

use App\Enums\CharacterSortEnum;
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
    public function getList(CharacterSortEnum $sort = CharacterSortEnum::Name, int $perPage = 30): LengthAwarePaginator
    {
        $query = Character::query()
            ->withCount('animes')
            ->with('media');

        return match ($sort) {
            CharacterSortEnum::Name => $query->orderBy('name')->paginate($perPage),
        };
    }
}
