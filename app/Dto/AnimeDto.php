<?php

namespace App\Dto;

use App\Enums\AnimeRatingEnum;
use App\Enums\AnimeRelationEnum;
use App\Enums\AnimeStatusEnum;
use App\Enums\AnimeTitleLanguageEnum;
use App\Enums\AnimeTypeEnum;
use App\Enums\MalEntryTypeEnum;
use App\Enums\SourceTypeEnum;
use Carbon\Carbon;

class AnimeDto
{
    /**
     * @param array<AnimeTitleDto> $titles
     * @param array<MalEntryDto> $genres
     * @param array<MalEntryDto> $themes
     * @param array<MalEntryDto> $studios
     * @param array<MalEntryDto> $producers
     * @param array<MalEntryDto> $licensors
     * @param array<RelatedAnimeGroupDto> $relatedAnime
     * @param array<ExternalLinkDto> $externalLinks
     */
    public function __construct(
        public readonly int              $malId,
        public readonly string           $title,
        public readonly AnimeTypeEnum    $type,
        public readonly ?string          $synopsis = null,
        public readonly ?int             $episodeCount = null,
        public readonly ?AnimeStatusEnum $status = null,
        public readonly ?Carbon          $airedFrom = null,
        public readonly ?Carbon          $airedTo = null,
        public readonly ?string          $airedString = null,
        public readonly ?bool            $airedUnknown = null,
        public readonly ?string          $broadcast = null,
        public readonly ?SourceTypeEnum  $sourceType = null,
        public readonly ?int             $duration = null,
        public readonly ?AnimeRatingEnum $rating = null,
        public readonly ?float           $score = null,
        public readonly ?int             $rank = null,
        public readonly ?float           $popularity = null,
        public readonly ?string          $imageUrl = null,
        public readonly ?string          $season = null,
        public readonly ?int             $year = null,
        public readonly array            $titles = [],
        public readonly array            $genres = [],
        public readonly array            $themes = [],
        public readonly array            $studios = [],
        public readonly array            $producers = [],
        public readonly array            $licensors = [],
        public readonly array            $relatedAnime = [],
        public readonly array            $externalLinks = [],
    ) {}

    /**
     * Create from an array.
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            malId: $data['mal_id'] ?? 0,
            title: $data['title'] ?? '',
            type: self::mapAnimeType($data['type'] ?? null),
            synopsis: $data['synopsis'] ?? null,
            episodeCount: $data['episodes'] ?? null,
            status: isset($data['status']) ? AnimeStatusEnum::fromString($data['status']) : null,
            airedFrom: isset($data['aired']['from']) ? Carbon::parse($data['aired']['from']) : null,
            airedTo: isset($data['aired']['to']) ? Carbon::parse($data['aired']['to']) : null,
            airedString: $data['aired_string'] ?? null,
            airedUnknown: $data['aired_unknown'] ?? null,
            broadcast: $data['broadcast'] ?? null,
            sourceType: isset($data['source']) ? SourceTypeEnum::fromString($data['source']) : null,
            duration: isset($data['duration']) ? self::parseDuration($data['duration']) : null,
            rating: isset($data['rating']) ? AnimeRatingEnum::fromString($data['rating']) : null,
            score: $data['score'] ?? null,
            rank: $data['rank'] ?? null,
            popularity: $data['popularity'] ?? null,
            imageUrl: $data['images']['jpg']['large_image_url'] ?? null,
            season: $data['season'] ?? null,
            year: isset($data['year']) ? (int) $data['year'] : null,
            titles: self::mapTitles($data['titles'] ?? []),
            genres: self::mapMalEntries($data['genres'] ?? []),
            themes: self::mapMalEntries($data['themes'] ?? []),
            studios: self::mapMalEntries($data['studios'] ?? []),
            producers: self::mapMalEntries($data['producers'] ?? []),
            licensors: self::mapMalEntries($data['licensors'] ?? []),
            relatedAnime: self::mapRelations($data['relations'] ?? []),
            externalLinks: self::mapExternalLinks($data['external'] ?? []),
        );
    }

    /**
     * Convert DTO fields to model attributes array.
     *
     * @return array<string, mixed>
     */
    public function toModelAttributes(): array
    {
        return [
            'mal_id' => $this->malId,
            'title' => $this->title,
            'synopsis' => $this->synopsis,
            'type' => $this->type,
            'episode_count' => $this->episodeCount,
            'status' => $this->status,
            'aired_from' => $this->airedFrom,
            'aired_to' => $this->airedTo,
            'aired_string' => $this->airedString,
            'aired_unknown' => $this->airedUnknown ?? false,
            'broadcast' => $this->broadcast,
            'source_type' => $this->sourceType,
            'duration' => $this->duration,
            'rating' => $this->rating,
            'score' => $this->score,
            'rank' => $this->rank,
            'popularity' => $this->popularity,
            'source_image_url' => $this->imageUrl,
        ];
    }

    private static function mapAnimeType(?string $type): AnimeTypeEnum
    {
        if ($type === null) {
            return AnimeTypeEnum::UNKNOWN;
        }

        return AnimeTypeEnum::fromString(strtolower($type));
    }

    /**
     * @param array<array{name?: string, url?: string}|ExternalLinkDto> $links
     * @return array<ExternalLinkDto>
     */
    private static function mapExternalLinks(array $links): array
    {
        $result = [];

        foreach ($links as $link) {
            if ($link instanceof ExternalLinkDto) {
                $result[] = $link;

                continue;
            }

            if (empty($link['url'])) {
                continue;
            }

            $result[] = new ExternalLinkDto(
                name: $link['name'] ?? '',
                url: $link['url'],
            );
        }

        return $result;
    }

    /**
     * @param array<array{mal_id?: int, name?: string}|MalEntryDto> $entries
     * @return array<MalEntryDto>
     */
    private static function mapMalEntries(array $entries): array
    {
        $result = [];

        foreach ($entries as $entry) {
            if ($entry instanceof MalEntryDto) {
                $result[] = $entry;

                continue;
            }

            $result[] = new MalEntryDto(
                malId: $entry['mal_id'] ?? 0,
                name: $entry['name'] ?? '',
            );
        }

        return $result;
    }

    /**
     * @param  array<int, array{relation?: string, entry?: array<int, array<string, mixed>>}|RelatedAnimeGroupDto>  $relations
     * @return array<RelatedAnimeGroupDto>
     */
    private static function mapRelations(array $relations): array
    {
        $result = [];

        foreach ($relations as $relation) {
            if ($relation instanceof RelatedAnimeGroupDto) {
                $result[] = $relation;

                continue;
            }

            $relationType = AnimeRelationEnum::fromString(strtolower(trim($relation['relation'] ?? '')));
            if ($relationType === null) {
                continue;
            }

            $entries = [];
            foreach ($relation['entry'] ?? [] as $entry) {
                $entryType = MalEntryTypeEnum::tryFrom($entry['type'] ?? '');
                if ($entryType === null) {
                    continue;
                }

                $entries[] = new RelatedAnimeEntryDto(
                    malId: $entry['mal_id'] ?? 0,
                    type: $entryType,
                    name: $entry['name'] ?? '',
                );
            }

            $result[] = new RelatedAnimeGroupDto(
                relation: $relationType,
                entries: $entries,
            );
        }

        return $result;
    }

    /**
     * @param array<array{type?: string, title?: string}|AnimeTitleDto> $titles
     * @return array<AnimeTitleDto>
     */
    private static function mapTitles(array $titles): array
    {
        $result = [];

        foreach ($titles as $title) {
            if ($title instanceof AnimeTitleDto) {
                $result[] = $title;

                continue;
            }

            if (!isset($title['type']) || $title['type'] === 'Default') {
                continue;
            }

            $language = AnimeTitleLanguageEnum::fromString($title['type']);
            if ($language === null) {
                continue;
            }

            $result[] = new AnimeTitleDto(
                language: $language,
                title: $title['title'] ?? '',
            );
        }

        return $result;
    }

    /**
     * Parse duration string to minutes.
     */
    private static function parseDuration(string $duration): ?int
    {
        preg_match('/(\d+)\s*hr/i', $duration, $hours);
        preg_match('/(\d+)\s*min/i', $duration, $minutes);

        $totalMinutes = 0;
        if (!empty($hours[1])) {
            $totalMinutes += (int)$hours[1] * 60;
        }
        if (!empty($minutes[1])) {
            $totalMinutes += (int)$minutes[1];
        }

        return $totalMinutes ?: null;
    }
}
