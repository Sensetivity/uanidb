<?php

namespace App\Enums;

enum AnimeRelationEnum: int
{
    case ADAPTATION = 5;
    case ALTERNATIVE = 3;
    case CHARACTER_STORY = 9;
    case FULL_STORY = 10;
    case OTHER = 99;
    case PARENT_STORY = 8;
    case PREQUEL = 2;
    case SEQUEL = 1;
    case SIDE_STORY = 6;
    case SPIN_OFF = 4;
    case SUMMARY = 7;

    private const MAP = [
        'sequel' => AnimeRelationEnum::SEQUEL,
        'prequel' => AnimeRelationEnum::PREQUEL,
        'side story' => AnimeRelationEnum::SIDE_STORY,
        'spin-off' => AnimeRelationEnum::SPIN_OFF,
        'adaptation' => AnimeRelationEnum::ADAPTATION,
        'alternative' => AnimeRelationEnum::ALTERNATIVE,
        'summary' => AnimeRelationEnum::SUMMARY,
        'parent' => AnimeRelationEnum::PARENT_STORY,
        'character' => AnimeRelationEnum::CHARACTER_STORY,
        'full story' => AnimeRelationEnum::FULL_STORY,
        'other' => AnimeRelationEnum::OTHER,
    ];

    public static function fromString(string $relation): ?AnimeRelationEnum
    {
        return self::MAP[$relation] ?? null;
    }
}
