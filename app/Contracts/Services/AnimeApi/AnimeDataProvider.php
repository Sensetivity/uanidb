<?php

namespace App\Contracts\Services\AnimeApi;

use App\Dto\AnimeDto;
use App\Dto\CharacterDto;
use App\Dto\EpisodeDto;
use App\Dto\PersonDto;
use App\Dto\PromotionVideoDto;

interface AnimeDataProvider
{
    /**
     * Get anime by ID from the API.
     *
     * @param int $id The API-specific ID of the anime
     */
    public function getAnime(int $id): ?AnimeDto;

    /**
     * Get characters for an anime.
     *
     * @return array<CharacterDto>
     */
    public function getAnimeCharacters(int $id): array;

    /**
     * Get episodes for an anime.
     *
     * @return array<EpisodeDto>
     */
    public function getAnimeEpisodes(int $id): array;

    /**
     * Get staff for an anime.
     *
     * @return array<PersonDto>
     */
    public function getAnimeStaff(int $id): array;

    /**
     * Get promotion videos for an anime.
     *
     * @return array<PromotionVideoDto>
     */
    public function getAnimeVideos(int $id): array;

    /**
     * Get seasonal anime.
     *
     * @param int $year Year
     * @param string $season Season name (winter, spring, summer, fall)
     * @param int $page Page number
     * @return array<AnimeDto>
     */
    public function getSeasonalAnime(int $year, string $season, int $page = 1): array;

    /**
     * Get top anime.
     *
     * @param string $type Type of ranking (all, airing, upcoming, tv, movie, ova, special)
     * @param int $page Page number
     * @return array<AnimeDto>
     */
    public function getTopAnime(string $type = 'all', int $page = 1): array;

    /**
     * Search for anime.
     *
     * @param string $query Search query
     * @param int $page Page number
     * @return array<AnimeDto>
     */
    public function searchAnime(string $query, int $page = 1): array;
}
