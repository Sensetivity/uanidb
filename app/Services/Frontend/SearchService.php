<?php

namespace App\Services\Frontend;

use App\Models\Anime;
use App\Models\Character;
use App\Models\Person;
use App\Models\Studio;
use Illuminate\Database\Eloquent\Collection;

class SearchService
{
    /**
     * @return array{anime: Collection<int, Anime>, characters: Collection<int, Character>, people: Collection<int, Person>, studios: Collection<int, Studio>}
     */
    public function search(string $query, string $category = 'all', int $limit = 10): array
    {
        $results = [
            'anime' => new Collection(),
            'characters' => new Collection(),
            'people' => new Collection(),
            'studios' => new Collection(),
        ];

        if (strlen($query) < 2) {
            return $results;
        }

        if ($category === 'all' || $category === 'anime') {
            $results['anime'] = Anime::query()
                ->search($query)
                ->with(['genres', 'media'])
                ->limit($limit)
                ->get();
        }

        if ($category === 'all' || $category === 'characters') {
            $results['characters'] = Character::query()
                ->search($query)
                ->with('media')
                ->limit($limit)
                ->get();
        }

        if ($category === 'all' || $category === 'people') {
            $results['people'] = Person::query()
                ->search($query)
                ->with('media')
                ->limit($limit)
                ->get();
        }

        if ($category === 'all' || $category === 'studios') {
            $results['studios'] = Studio::query()
                ->search($query)
                ->with('media')
                ->limit($limit)
                ->get();
        }

        return $results;
    }
}
