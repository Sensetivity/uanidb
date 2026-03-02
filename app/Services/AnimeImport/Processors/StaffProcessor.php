<?php

namespace App\Services\AnimeImport\Processors;

use App\Dto\AnimeFullDto;
use App\Models\Anime;
use App\Models\Person;
use Illuminate\Support\Facades\DB;

class StaffProcessor implements RelationProcessor
{
    public function clear(Anime $anime): void
    {
        $anime->people()->detach();
    }

    public function sync(Anime $anime, AnimeFullDto $dto): void
    {
        foreach ($dto->staff as $personDto) {
            $person = Person::query()->updateOrCreate(
                ['mal_id' => $personDto->malId],
                [
                    'name' => $personDto->name,
                    'image_url' => $personDto->imageUrl,
                ],
            );

            foreach ($personDto->positions as $position) {
                DB::table('anime_person')->insertOrIgnore([
                    'anime_id' => $anime->id,
                    'person_id' => $person->id,
                    'role' => $position,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
