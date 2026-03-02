<?php

namespace App\Dto;

readonly class ExternalLinkDto
{
    public function __construct(
        public string $name,
        public string $url,
    ) {}
}
