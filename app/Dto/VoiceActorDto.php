<?php

namespace App\Dto;

readonly class VoiceActorDto
{
    public function __construct(
        public int $malId,
        public string $name,
        public ?string $imageUrl = null,
        public string $language = 'Japanese',
    ) {}
}
