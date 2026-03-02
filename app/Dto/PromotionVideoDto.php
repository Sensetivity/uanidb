<?php

namespace App\Dto;

readonly class PromotionVideoDto
{
    public function __construct(
        public string $title,
        public string $videoUrl,
    ) {}
}
