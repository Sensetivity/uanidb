<?php

namespace App\Services\AnimeImport;

use App\Contracts\Services\AnimeApi\AnimeDataProvider;
use App\Dto\AnimeDto;
use App\Dto\AnimeFullDto;
use App\Models\Anime;
use App\Services\AnimeApi\JikanAnimeApiClientException;
use App\Services\AnimeImport\Processors\RelationProcessor;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnimeImportService
{
    /**
     * @param array<RelationProcessor> $processors
     * @param int $rateLimitDelay Delay in seconds between batch imports
     * @param int $apiDelay Delay in seconds between API detail requests
     * @param array<RelationProcessor> $baseProcessors
     */
    public function __construct(
        private readonly AnimeDataProvider $apiClient,
        private readonly array             $processors,
        private readonly int               $rateLimitDelay = 2,
        private readonly int               $apiDelay = 1,
        private readonly array             $baseProcessors = [],
    ) {}

    /**
     * Import anime by MAL ID.
     *
     * @throws AnimeImportServiceException
     */
    public function importAnimeByMalId(int $malId, bool $forceUpdate = false): ?Anime
    {
        try {
            $existingAnime = Anime::query()->where('mal_id', $malId)->first();
            if ($existingAnime && !$forceUpdate) {
                return $existingAnime;
            }

            $dto = $this->apiClient->getAnime($malId);
            if (!$dto) {
                return null;
            }

            sleep($this->apiDelay);

            $fullDto = $this->buildFullDto($dto);

            return DB::transaction(function () use ($fullDto, $existingAnime) {
                if ($existingAnime) {
                    return $this->updateAnime($existingAnime, $fullDto);
                }

                return $this->createAnime($fullDto);
            });
        } catch (JikanAnimeApiClientException $e) {
            $this->handleException('Failed to import anime due to API error', $e);
        } catch (Exception $e) {
            $this->handleException('Failed to import anime', $e);
        }
    }

    /**
     * Import multiple anime by MAL IDs.
     *
     * @param array<int> $malIds
     * @return array<Anime>
     */
    public function importAnimeByMalIds(array $malIds, bool $forceUpdate = false): array
    {
        return $this->batchImport(
            $malIds,
            fn (int $malId) => $this->importAnimeByMalId($malId, $forceUpdate),
        );
    }

    /**
     * Import only base anime data (no episodes, characters, staff, or videos).
     *
     * @throws AnimeImportServiceException
     */
    public function importBaseAnimeByMalId(int $malId, bool $forceUpdate = false): ?Anime
    {
        try {
            $existingAnime = Anime::query()->where('mal_id', $malId)->first();
            if ($existingAnime && !$forceUpdate) {
                return $existingAnime;
            }

            $dto = $this->apiClient->getAnime($malId);
            if (!$dto) {
                return null;
            }

            $fullDto = new AnimeFullDto(anime: $dto);

            return DB::transaction(function () use ($fullDto, $existingAnime) {
                if ($existingAnime) {
                    $existingAnime->update($fullDto->anime->toModelAttributes());

                    $this->clearBaseProcessors($existingAnime);
                    $this->syncBaseProcessors($existingAnime, $fullDto);

                    Log::info("Updated base anime: {$existingAnime->title} (ID: {$existingAnime->id})");

                    return $existingAnime;
                }

                $anime = Anime::query()->create($fullDto->anime->toModelAttributes());

                $this->syncBaseProcessors($anime, $fullDto);

                Log::info("Created base anime: {$anime->title} (ID: {$anime->id})");

                return $anime;
            });
        } catch (JikanAnimeApiClientException $e) {
            $this->handleException('Failed to import base anime due to API error', $e);
        } catch (Exception $e) {
            $this->handleException('Failed to import base anime', $e);
        }
    }

    /**
     * Import characters and staff for an existing anime.
     *
     * @throws AnimeImportServiceException
     */
    public function importCharactersAndStaff(Anime $anime): void
    {
        try {
            $characters = $this->apiClient->getAnimeCharacters($anime->mal_id);

            sleep($this->apiDelay);

            $staff = $this->apiClient->getAnimeStaff($anime->mal_id);

            $fullDto = $this->buildPartialDto($anime, characters: $characters, staff: $staff);

            DB::transaction(function () use ($anime, $fullDto) {
                $characterProcessor = $this->findProcessor(Processors\CharacterProcessor::class);
                $staffProcessor = $this->findProcessor(Processors\StaffProcessor::class);

                $characterProcessor->clear($anime);
                $staffProcessor->clear($anime);
                $characterProcessor->sync($anime, $fullDto);
                $staffProcessor->sync($anime, $fullDto);
            });

            Log::info("Imported characters and staff for anime: {$anime->title} (ID: {$anime->id})");
        } catch (JikanAnimeApiClientException $e) {
            $this->handleException("Failed to import characters/staff for anime {$anime->mal_id} due to API error", $e);
        } catch (Exception $e) {
            $this->handleException("Failed to import characters/staff for anime {$anime->mal_id}", $e);
        }
    }

    /**
     * Import episodes for an existing anime.
     *
     * @throws AnimeImportServiceException
     */
    public function importEpisodes(Anime $anime): void
    {
        try {
            $episodes = $this->apiClient->getAnimeEpisodes($anime->mal_id);

            $fullDto = $this->buildPartialDto($anime, episodes: $episodes);

            DB::transaction(function () use ($anime, $fullDto) {
                $processor = $this->findProcessor(Processors\EpisodeProcessor::class);
                $processor->clear($anime);
                $processor->sync($anime, $fullDto);
            });

            Log::info("Imported episodes for anime: {$anime->title} (ID: {$anime->id})");
        } catch (JikanAnimeApiClientException $e) {
            $this->handleException("Failed to import episodes for anime {$anime->mal_id} due to API error", $e);
        } catch (Exception $e) {
            $this->handleException("Failed to import episodes for anime {$anime->mal_id}", $e);
        }
    }

    /**
     * Import promotion videos for an existing anime.
     *
     * @throws AnimeImportServiceException
     */
    public function importPromotionVideos(Anime $anime): void
    {
        try {
            $promotionVideos = $this->apiClient->getAnimeVideos($anime->mal_id);

            $fullDto = $this->buildPartialDto($anime, promotionVideos: $promotionVideos);

            DB::transaction(function () use ($anime, $fullDto) {
                $processor = $this->findProcessor(Processors\PromotionVideoProcessor::class);
                $processor->clear($anime);
                $processor->sync($anime, $fullDto);
            });

            Log::info("Imported promotion videos for anime: {$anime->title} (ID: {$anime->id})");
        } catch (JikanAnimeApiClientException $e) {
            $this->handleException("Failed to import videos for anime {$anime->mal_id} due to API error", $e);
        } catch (Exception $e) {
            $this->handleException("Failed to import videos for anime {$anime->mal_id}", $e);
        }
    }

    /**
     * Import seasonal anime.
     *
     * @return array<Anime>
     *
     * @throws AnimeImportServiceException
     */
    public function importSeasonalAnime(int $year, string $season, int $pages = 1, bool $forceUpdate = false): array
    {
        try {
            $animeList = [];

            for ($page = 1; $page <= $pages; $page++) {
                $pageResults = $this->apiClient->getSeasonalAnime($year, $season, $page);
                if (empty($pageResults)) {
                    break;
                }

                $animeList = array_merge($animeList, $pageResults);

                if ($page < $pages) {
                    sleep($this->rateLimitDelay);
                }
            }

            return $this->importAnimeList($animeList, $forceUpdate);
        } catch (JikanAnimeApiClientException $e) {
            $this->handleException('Failed to import seasonal anime due to API error', $e);
        } catch (Exception $e) {
            $this->handleException('Failed to import seasonal anime', $e);
        }
    }

    /**
     * Import top anime.
     *
     * @return array<Anime>
     *
     * @throws AnimeImportServiceException
     */
    public function importTopAnime(string $type = 'all', int $pages = 1, bool $forceUpdate = false): array
    {
        try {
            $animeList = [];

            for ($page = 1; $page <= $pages; $page++) {
                $pageResults = $this->apiClient->getTopAnime($type, $page);
                if (empty($pageResults)) {
                    break;
                }

                $animeList = array_merge($animeList, $pageResults);

                if ($page < $pages) {
                    sleep($this->rateLimitDelay);
                }
            }

            return $this->importAnimeList($animeList, $forceUpdate);
        } catch (JikanAnimeApiClientException $e) {
            $this->handleException('Failed to import top anime due to API error', $e);
        } catch (Exception $e) {
            $this->handleException('Failed to import top anime', $e);
        }
    }

    /**
     * @param  array<int, mixed>  $items
     * @return array<Anime>
     */
    private function batchImport(array $items, callable $importCallback): array
    {
        $results = [];

        foreach ($items as $item) {
            try {
                $result = $importCallback($item);
                if ($result) {
                    $results[] = $result;
                }
            } catch (Exception $e) {
                Log::warning('Import failed for item: ' . json_encode($item), [
                    'exception' => $e->getMessage(),
                ]);

                continue;
            }

            sleep($this->rateLimitDelay);
        }

        return $results;
    }

    private function buildFullDto(AnimeDto $dto): AnimeFullDto
    {
        $episodes = $this->fetchDetailData(
            fn () => $this->apiClient->getAnimeEpisodes($dto->malId),
            "episodes for anime {$dto->malId}",
        );

        sleep($this->apiDelay);

        $characters = $this->fetchDetailData(
            fn () => $this->apiClient->getAnimeCharacters($dto->malId),
            "characters for anime {$dto->malId}",
        );

        sleep($this->apiDelay);

        $staff = $this->fetchDetailData(
            fn () => $this->apiClient->getAnimeStaff($dto->malId),
            "staff for anime {$dto->malId}",
        );

        sleep($this->apiDelay);

        $promotionVideos = $this->fetchDetailData(
            fn () => $this->apiClient->getAnimeVideos($dto->malId),
            "videos for anime {$dto->malId}",
        );

        return new AnimeFullDto(
            anime: $dto,
            episodes: $episodes,
            characters: $characters,
            staff: $staff,
            promotionVideos: $promotionVideos,
        );
    }

    /**
     * @param  array<int, mixed>  $episodes
     * @param  array<int, mixed>  $characters
     * @param  array<int, mixed>  $staff
     * @param  array<int, mixed>  $promotionVideos
     */
    private function buildPartialDto(
        Anime $anime,
        array $episodes = [],
        array $characters = [],
        array $staff = [],
        array $promotionVideos = [],
    ): AnimeFullDto {
        $animeDto = new AnimeDto(
            malId: $anime->mal_id,
            title: $anime->title,
            type: $anime->type,
        );

        return new AnimeFullDto(
            anime: $animeDto,
            episodes: $episodes,
            characters: $characters,
            staff: $staff,
            promotionVideos: $promotionVideos,
        );
    }

    private function clearBaseProcessors(Anime $anime): void
    {
        foreach ($this->baseProcessors as $processor) {
            $processor->clear($anime);
        }
    }

    private function clearProcessors(Anime $anime): void
    {
        foreach ($this->processors as $processor) {
            $processor->clear($anime);
        }
    }

    private function createAnime(AnimeFullDto $fullDto): Anime
    {
        $anime = Anime::query()->create($fullDto->anime->toModelAttributes());

        $this->syncProcessors($anime, $fullDto);

        Log::info("Created anime: {$anime->title} (ID: {$anime->id})");

        return $anime;
    }

    /**
     * @return array<mixed>
     */
    private function fetchDetailData(callable $fetcher, string $context): array
    {
        try {
            return $fetcher();
        } catch (Exception $e) {
            Log::warning("Failed to fetch {$context}: {$e->getMessage()}");

            return [];
        }
    }

    private function findProcessor(string $class): RelationProcessor
    {
        foreach ($this->processors as $processor) {
            if ($processor instanceof $class) {
                return $processor;
            }
        }

        throw new \RuntimeException("Processor {$class} not found.");
    }

    /**
     * @throws AnimeImportServiceException
     */
    private function handleException(string $message, Exception $e): never
    {
        Log::error($message, [
            'exception' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        throw new AnimeImportServiceException("{$message}: {$e->getMessage()}", 0, $e);
    }

    /**
     * @param array<AnimeDto> $animeList
     * @return array<Anime>
     */
    private function importAnimeList(array $animeList, bool $forceUpdate = false): array
    {
        return $this->batchImport(
            $animeList,
            fn (AnimeDto $dto) => $this->importAnimeByMalId($dto->malId, $forceUpdate),
        );
    }

    private function syncBaseProcessors(Anime $anime, AnimeFullDto $fullDto): void
    {
        foreach ($this->baseProcessors as $processor) {
            $processor->sync($anime, $fullDto);
        }
    }

    private function syncProcessors(Anime $anime, AnimeFullDto $fullDto): void
    {
        foreach ($this->processors as $processor) {
            $processor->sync($anime, $fullDto);
        }
    }

    private function updateAnime(Anime $anime, AnimeFullDto $fullDto): Anime
    {
        $anime->update($fullDto->anime->toModelAttributes());

        $this->clearProcessors($anime);
        $this->syncProcessors($anime, $fullDto);

        Log::info("Updated anime: {$anime->title} (ID: {$anime->id})");

        return $anime;
    }
}
