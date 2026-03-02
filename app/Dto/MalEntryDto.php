<?php

namespace App\Dto;

readonly class MalEntryDto
{
    public function __construct(
        public int $malId,
        public string $name,
    ) {}
}
