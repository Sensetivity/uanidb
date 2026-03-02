<?php

namespace App\Dto;

readonly class PersonDto
{
    /**
     * @param array<string> $positions
     */
    public function __construct(
        public int $malId,
        public string $name,
        public ?string $imageUrl = null,
        public array $positions = [],
    ) {}
}
