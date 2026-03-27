<?php

namespace App\Services\Frontend;

use App\Enums\PersonSortEnum;
use App\Models\Person;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PersonService
{
    public function findBySlug(string $slug): Person
    {
        /** @var Person $person */
        $person = Person::query()
            ->where('slug', $slug)
            ->with([
                'voicedCharacters.media',
                'animes.media',
                'media',
            ])
            ->firstOrFail();

        return $person;
    }

    /**
     * @return LengthAwarePaginator<int, Person>
     */
    public function getList(PersonSortEnum $sort = PersonSortEnum::Name, int $perPage = 30): LengthAwarePaginator
    {
        $query = Person::query()
            ->withCount('voicedCharacters')
            ->with('media');

        return match ($sort) {
            PersonSortEnum::Name => $query->orderBy('name')->paginate($perPage),
        };
    }
}
