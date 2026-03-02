<?php

namespace App\Dto;

use App\Enums\CharacterRoleEnum;

readonly class CharacterDto
{
    /**
     * @param array<VoiceActorDto> $voiceActors
     */
    public function __construct(
        public int $malId,
        public string $name,
        public ?string $imageUrl = null,
        public CharacterRoleEnum $role = CharacterRoleEnum::SUPPORTING,
        public array $voiceActors = [],
    ) {}
}
