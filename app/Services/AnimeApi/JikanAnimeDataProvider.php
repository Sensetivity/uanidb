<?php

namespace App\Services\AnimeApi;

use App\Contracts\Services\AnimeApi\AnimeDataProvider;
use App\Dto\AnimeDto;
use App\Dto\CharacterDto;
use App\Dto\EpisodeDto;
use App\Dto\PersonDto;
use App\Dto\PromotionVideoDto;
use App\Dto\VoiceActorDto;
use App\Enums\CharacterRoleEnum;
use Carbon\Carbon;
use Exception;
use Jikan\JikanPHP\Client;
use Jikan\JikanPHP\Model\AnimeFull;

class JikanAnimeDataProvider implements AnimeDataProvider
{
    public function __construct(
        private readonly Client $client,
        private readonly int    $apiDelay = 1,
    )
    {
    }

    /**
     * @throws JikanAnimeApiClientException
     */
    public function getAnime(int $id): ?AnimeDto
    {
        try {
            $response = $this->client->getAnimeFullById($id);
            if (!$response) {
                return null;
            }

            return AnimeDto::fromArray($this->extractAnimeData($response->getData()));
        } catch (Exception $e) {
            throw new JikanAnimeApiClientException("Failed to fetch anime with ID: {$id}", 0, $e);
        }
    }

    /**
     * @return array<AnimeDto>
     *
     * @throws JikanAnimeApiClientException
     */
    public function searchAnime(string $query, int $page = 1): array
    {
        try {
            $response = $this->client->getAnimeSearch([
                'q' => $query,
                'page' => $page,
            ]);
            $results = [];

            if (!$response || !$response->getData()) {
                return $results;
            }

            foreach ($response->getData() as $animeItem) {
                $data = $this->extractAnimeData($animeItem);
                $results[] = AnimeDto::fromArray($data);
            }

            return $results;
        } catch (Exception $e) {
            throw new JikanAnimeApiClientException("Failed to search anime with query: {$query}", 0, $e);
        }
    }

    /**
     * @return array<AnimeDto>
     *
     * @throws JikanAnimeApiClientException
     */
    public function getSeasonalAnime(int $year, string $season, int $page = 1): array
    {
        try {
            $response = $this->client->getSeason($year, $season, ['page' => $page]);
            if (!$response) {
                return [];
            }

            $results = [];
            foreach ($response->getData() as $animeItem) {
                $data = $this->extractAnimeData($animeItem);
                $results[] = AnimeDto::fromArray($data);
            }

            return $results;
        } catch (Exception $e) {
            throw new JikanAnimeApiClientException("Failed to fetch seasonal anime: {$season} {$year}", 0, $e);
        }
    }

    /**
     * @return array<AnimeDto>
     *
     * @throws JikanAnimeApiClientException
     */
    public function getTopAnime(string $type = 'all', int $page = 1): array
    {
        try {
            $response = $this->client->getTopAnime([
                'type' => $type,
                'page' => $page,
            ]);
            $results = [];

            if (!$response || !$response->getData()) {
                return $results;
            }

            foreach ($response->getData() as $animeItem) {
                $data = $this->extractAnimeData($animeItem);
                $results[] = AnimeDto::fromArray($data);
            }

            return $results;
        } catch (Exception $e) {
            throw new JikanAnimeApiClientException("Failed to fetch top anime of type: {$type}", 0, $e);
        }
    }

    /**
     * @return array<EpisodeDto>
     *
     * @throws JikanAnimeApiClientException
     */
    public function getAnimeEpisodes(int $id): array
    {
        try {
            $episodes = [];
            $page = 1;

            do {
                $response = $this->client->getAnimeEpisodes($id, ['page' => $page]);
                if (!$response || !$response->getData()) {
                    break;
                }

                foreach ($response->getData() as $index => $episodeItem) {
                    $number = ($page - 1) * 100 + $index + 1;
                    $episodes[] = EpisodeDto::fromJikanArray([
                        'mal_id' => $episodeItem->getMalId(),
                        'title' => $episodeItem->getTitle(),
                        'title_japanese' => $episodeItem->getTitleJapanese(),
                        'title_romanji' => $episodeItem->getTitleRomanji(),
                        'aired' => $episodeItem->getAired(),
                        'duration' => $episodeItem->getDuration(),
                        'filler' => $episodeItem->getFiller(),
                        'recap' => $episodeItem->getRecap(),
                    ], $number);
                }

                $hasNextPage = $response->getPagination()?->getHasNextPage() ?? false;
                $page++;

                if ($hasNextPage) {
                    sleep($this->apiDelay);
                }
            } while ($hasNextPage);

            return $episodes;
        } catch (Exception $e) {
            throw new JikanAnimeApiClientException("Failed to fetch episodes for anime ID: {$id}", 0, $e);
        }
    }

    /**
     * @return array<CharacterDto>
     *
     * @throws JikanAnimeApiClientException
     */
    public function getAnimeCharacters(int $id): array
    {
        try {
            $response = $this->client->getAnimeCharacters($id);
            if (!$response || !$response->getData()) {
                return [];
            }

            $characters = [];
            foreach ($response->getData() as $item) {
                $charData = $item->getCharacter();
                $charImages = $charData->getImages();

                $voiceActors = [];
                foreach ($item->getVoiceActors() as $va) {
                    $person = $va->getPerson();
                    $personImages = $person->getImages();

                    $voiceActors[] = new VoiceActorDto(
                        malId: $person->getMalId(),
                        name: $person->getName(),
                        imageUrl: $personImages?->getJpg()?->getImageUrl(),
                        language: $va->getLanguage(),
                    );
                }

                $characters[] = new CharacterDto(
                    malId: $charData->getMalId(),
                    name: $charData->getName(),
                    imageUrl: $charImages?->getJpg()?->getImageUrl(),
                    role: CharacterRoleEnum::fromString($item->getRole()),
                    voiceActors: $voiceActors,
                );
            }

            return $characters;
        } catch (Exception $e) {
            throw new JikanAnimeApiClientException("Failed to fetch characters for anime ID: {$id}", 0, $e);
        }
    }

    /**
     * @return array<PersonDto>
     *
     * @throws JikanAnimeApiClientException
     */
    public function getAnimeStaff(int $id): array
    {
        try {
            $response = $this->client->getAnimeStaff($id);
            if (!$response || !$response->getData()) {
                return [];
            }

            $staff = [];
            foreach ($response->getData() as $item) {
                $person = $item->getPerson();
                $personImages = $person->getImages();

                $staff[] = new PersonDto(
                    malId: $person->getMalId(),
                    name: $person->getName(),
                    imageUrl: $personImages?->getJpg()?->getImageUrl(),
                    positions: $item->getPositions(),
                );
            }

            return $staff;
        } catch (Exception $e) {
            throw new JikanAnimeApiClientException("Failed to fetch staff for anime ID: {$id}", 0, $e);
        }
    }

    /**
     * @return array<PromotionVideoDto>
     *
     * @throws JikanAnimeApiClientException
     */
    public function getAnimeVideos(int $id): array
    {
        try {
            $response = $this->client->getAnimeVideos($id);
            if (!$response || !$response->getData()) {
                return [];
            }

            $videos = [];
            foreach ($response->getData()->getPromo() as $promo) {
                $trailer = $promo->getTrailer();
                $url = null;

                if ($trailer && method_exists($trailer, 'getUrl')) {
                    $url = $trailer->getUrl();
                }

                if (!$url) {
                    continue;
                }

                $videos[] = new PromotionVideoDto(
                    title: $promo->getTitle(),
                    videoUrl: $url,
                );
            }

            return $videos;
        } catch (Exception $e) {
            throw new JikanAnimeApiClientException("Failed to fetch videos for anime ID: {$id}", 0, $e);
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function extractAnimeData(AnimeFull $animeData): array
    {
        $aired = $animeData->getAired();
        $images = $animeData->getImages();

        return [
            'mal_id' => $animeData->getMalId(),
            'title' => $animeData->getTitle(),
            'synopsis' => $animeData->getSynopsis(),
            'type' => $animeData->getType(),
            'episodes' => $animeData->getEpisodes(),
            'status' => $animeData->getStatus(),
            'aired' => [
                'from' => $aired ? $aired->getFrom() : null,
                'to' => $aired ? $aired->getTo() : null,
            ],
            'duration' => $animeData->getDuration(),
            'rating' => $animeData->getRating(),
            'score' => $animeData->getScore(),
            'rank' => $animeData->getRank(),
            'popularity' => $animeData->getPopularity(),
            'images' => [
                'jpg' => [
                    'large_image_url' => $images->getJpg() ? $images->getJpg()->getLargeImageUrl() : null,
                ],
            ],
            'titles' => $this->convertTitlesToArray($animeData->getTitles()),
            'genres' => $this->convertMalUrlsToArray($animeData->getGenres()),
            'themes' => $this->convertMalUrlsToArray($animeData->getThemes()),
            'studios' => $this->convertMalUrlsToArray($animeData->getStudios()),
            'producers' => $this->convertMalUrlsToArray($animeData->getProducers()),
            'licensors' => $this->convertMalUrlsToArray($animeData->getLicensors()),
            'source' => $animeData->getSource(),
            'season' => $animeData->getSeason(),
            'year' => $animeData->getYear(),
            'relations' => $this->convertRelationsToArray($animeData->getRelations()),
            'external' => $this->convertExternalLinksToArray($animeData->getExternal()),
        ];
    }

    /**
     * @return array<int, array{type: string, title: string}>
     */
    private function convertTitlesToArray(array $titles): array
    {
        $result = [];
        foreach ($titles as $title) {
            $result[] = [
                'type' => $title->getType() ?? 'Default',
                'title' => $title->getTitle() ?? '',
            ];
        }

        return $result;
    }

    /**
     * @return array<int, array{mal_id: int, name: string}>
     */
    private function convertMalUrlsToArray(array $malUrls): array
    {
        $result = [];
        foreach ($malUrls as $malUrl) {
            $result[] = [
                'mal_id' => $malUrl->getMalId(),
                'name' => $malUrl->getName(),
            ];
        }

        return $result;
    }

    /**
     * @return array<int, array{relation: string, entry: array<int, array{mal_id: int, type: string, name: string}>}>
     */
    private function convertRelationsToArray(array $relations): array
    {
        $result = [];
        foreach ($relations as $relationGroup) {
            $entries = [];
            foreach ($relationGroup->getEntry() as $entry) {
                $entries[] = [
                    'mal_id' => $entry->getMalId(),
                    'type'   => $entry->getType(),
                    'name'   => $entry->getName(),
                ];
            }

            $result[] = [
                'relation' => $relationGroup->getRelation(),
                'entry'    => $entries,
            ];
        }

        return $result;
    }

    /**
     * @return array<int, array{name: string, url: string}>
     */
    private function convertExternalLinksToArray(array $links): array
    {
        $result = [];
        foreach ($links as $link) {
            $result[] = [
                'name' => $link->getName(),
                'url'  => $link->getUrl(),
            ];
        }

        return $result;
    }
}
