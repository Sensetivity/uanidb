<?php

namespace App\Services\TitleImport\Providers;

use App\Contracts\Services\TitleImport\TitleImportProvider;
use App\Enums\AnimeTitleTypeEnum;
use App\Models\Anime;
use App\Models\Episode;
use App\Services\TitleImport\Dto\AnimeTitleImportDto;
use App\Services\TitleImport\Dto\EpisodeTitleImportDto;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;

class AniDbTitleImportProvider implements TitleImportProvider
{
    private const TITLES_DUMP_URL = 'https://anidb.net/api/anime-titles.xml.gz';

    private const TITLES_CACHE_FILE = 'anidb/titles.xml';

    private const TITLES_CACHE_TTL = 86400; // 24 hours in seconds

    private const EPISODE_CACHE_TTL = 604800; // 7 days in seconds

    private const EPISODE_API_DELAY = 2; // seconds between API requests

    public function __construct(
        private readonly string $client,
        private readonly string $clientVer,
    ) {}

    /**
     * @return AnimeTitleImportDto[]
     */
    public function getAnimeUkTitles(Anime $anime): array
    {
        if (! $anime->anidb_id) {
            return [];
        }

        $xml = $this->getTitlesDump();

        if ($xml === null) {
            return [];
        }

        return $this->parseAnimeTitles($xml, $anime->anidb_id);
    }

    public function getEpisodeUkTitle(Episode $episode): ?EpisodeTitleImportDto
    {
        $anime = $episode->anime;

        if (! $anime->anidb_id) {
            return null;
        }

        $xml = $this->getAnimeXml($anime->anidb_id);

        if ($xml === null) {
            return null;
        }

        return $this->parseEpisodeTitle($xml, $episode->number);
    }

    /**
     * Download and cache the AniDB title dump XML.
     * Decompresses the .gz file and stores plain XML in cache.
     */
    private function getTitlesDump(): ?SimpleXMLElement
    {
        $cacheFile = self::TITLES_CACHE_FILE;
        $disk = Storage::disk('local');

        if ($disk->exists($cacheFile) && $disk->lastModified($cacheFile) > (time() - self::TITLES_CACHE_TTL)) {
            $content = $disk->get($cacheFile);
        } else {
            try {
                $response = Http::timeout(60)->get(self::TITLES_DUMP_URL);

                if (! $response->successful()) {
                    Log::warning('AniDB title dump download failed', ['status' => $response->status()]);

                    return null;
                }

                $content = gzdecode($response->body());

                if ($content === false) {
                    Log::warning('AniDB title dump decompression failed');

                    return null;
                }

                $disk->put($cacheFile, $content);
            } catch (\Throwable $e) {
                Log::warning('AniDB title dump fetch error', ['error' => $e->getMessage()]);

                return null;
            }
        }

        return $this->parseXml($content);
    }

    /**
     * Fetch and cache the AniDB HTTP API response for a specific anime.
     */
    private function getAnimeXml(int $anidbId): ?SimpleXMLElement
    {
        $cacheFile = "anidb/anime_{$anidbId}.xml";
        $disk = Storage::disk('local');

        if ($disk->exists($cacheFile) && $disk->lastModified($cacheFile) > (time() - self::EPISODE_CACHE_TTL)) {
            $content = $disk->get($cacheFile);
        } else {
            if (! $this->client) {
                Log::warning('AniDB client not configured, cannot fetch episode titles');

                return null;
            }

            sleep(self::EPISODE_API_DELAY);

            try {
                $url = "http://api.anidb.net:9001/httpapi";
                $response = Http::timeout(30)->get($url, [
                    'request'   => 'anime',
                    'aid'       => $anidbId,
                    'client'    => $this->client,
                    'clientver' => $this->clientVer,
                    'protover'  => '1',
                ]);

                if (! $response->successful()) {
                    Log::warning('AniDB HTTP API request failed', ['aid' => $anidbId, 'status' => $response->status()]);

                    return null;
                }

                $content = $response->body();
                $disk->put($cacheFile, $content);
            } catch (\Throwable $e) {
                Log::warning('AniDB HTTP API error', ['aid' => $anidbId, 'error' => $e->getMessage()]);

                return null;
            }
        }

        return $this->parseXml($content);
    }

    /**
     * @return AnimeTitleImportDto[]
     */
    private function parseAnimeTitles(SimpleXMLElement $xml, int $anidbId): array
    {
        $results = [];

        foreach ($xml->anime as $animeNode) {
            $aid = (int) $animeNode->attributes()['aid'];

            if ($aid !== $anidbId) {
                continue;
            }

            foreach ($animeNode->title as $titleNode) {
                $attrs = $titleNode->attributes('xml', true);
                $lang = (string) $attrs['lang'];
                $type = (string) $titleNode->attributes()['type'];

                if ($lang !== 'uk') {
                    continue;
                }

                $results[] = new AnimeTitleImportDto(
                    title: (string) $titleNode,
                    source: AnimeTitleTypeEnum::fromAniDbType($type),
                );
            }

            break;
        }

        return $results;
    }

    private function parseEpisodeTitle(SimpleXMLElement $xml, int $episodeNumber): ?EpisodeTitleImportDto
    {
        if (! isset($xml->episodes)) {
            return null;
        }

        foreach ($xml->episodes->episode as $episodeNode) {
            $epnoNode = $episodeNode->epno;

            if (! $epnoNode) {
                continue;
            }

            // Only regular episodes (type=1)
            $epnoType = (int) $epnoNode->attributes()['type'];

            if ($epnoType !== 1) {
                continue;
            }

            if ((int) $epnoNode !== $episodeNumber) {
                continue;
            }

            foreach ($episodeNode->title as $titleNode) {
                $attrs = $titleNode->attributes('xml', true);
                $lang = (string) $attrs['lang'];

                if ($lang === 'uk') {
                    return new EpisodeTitleImportDto(titleUk: (string) $titleNode);
                }
            }

            break;
        }

        return null;
    }

    private function parseXml(string $content): ?SimpleXMLElement
    {
        try {
            $previous = libxml_use_internal_errors(true);
            $xml = simplexml_load_string($content);
            libxml_use_internal_errors($previous);

            return $xml ?: null;
        } catch (\Throwable $e) {
            Log::warning('AniDB XML parse error', ['error' => $e->getMessage()]);

            return null;
        }
    }
}
