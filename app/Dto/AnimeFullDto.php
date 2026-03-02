<?php

namespace App\Dto;

readonly class AnimeFullDto
{
    /**
     * @param array<EpisodeDto> $episodes
     * @param array<CharacterDto> $characters
     * @param array<PersonDto> $staff
     * @param array<PromotionVideoDto> $promotionVideos
     */
    public function __construct(
        public AnimeDto $anime,
        public array $episodes = [],
        public array $characters = [],
        public array $staff = [],
        public array $promotionVideos = [],
    ) {}
}
