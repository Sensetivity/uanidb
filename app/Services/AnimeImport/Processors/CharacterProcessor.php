<?php

namespace App\Services\AnimeImport\Processors;

use App\Dto\AnimeFullDto;
use App\Models\Anime;
use App\Models\Character;
use App\Models\Person;
use Illuminate\Support\Facades\DB;

class CharacterProcessor implements RelationProcessor
{
    public function sync(Anime $anime, AnimeFullDto $dto): void
    {
        $characterPivot = [];

        foreach ($dto->characters as $charDto) {
            $character = Character::query()->updateOrCreate(
                ['mal_id' => $charDto->malId],
                [
                    'name' => $charDto->name,
                    'image_url' => $charDto->imageUrl,
                ],
            );

            $characterPivot[$character->id] = ['role' => $charDto->role->value];

            foreach ($charDto->voiceActors as $vaDto) {
                $person = Person::query()->updateOrCreate(
                    ['mal_id' => $vaDto->malId],
                    [
                        'name' => $vaDto->name,
                        'image_url' => $vaDto->imageUrl,
                    ],
                );

                DB::table('character_voice')->insertOrIgnore([
                    'character_id' => $character->id,
                    'person_id' => $person->id,
                    'anime_id' => $anime->id,
                    'language' => $vaDto->language,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $anime->characters()->sync($characterPivot);
    }

    public function clear(Anime $anime): void
    {
        DB::table('character_voice')->where('anime_id', $anime->id)->delete();
        $anime->characters()->detach();
    }
}
