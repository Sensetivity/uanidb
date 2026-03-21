<?php

namespace App\Services\Frontend;

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
    public function getList(string $sortBy = 'name', int $perPage = 30): LengthAwarePaginator
    {
        return Person::query()
            ->withCount('voicedCharacters')
            ->with('media')
            ->orderBy($sortBy)
            ->paginate($perPage);
    }
}
