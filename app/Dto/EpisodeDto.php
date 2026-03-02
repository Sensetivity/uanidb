<?php

namespace App\Dto;

use Carbon\Carbon;

readonly class EpisodeDto
{
    public function __construct(
        public int $malId,
        public int $number,
        public string $title,
        public ?string $titleJa = null,
        public ?string $titleRo = null,
        public ?string $synopsis = null,
        public ?Carbon $aired = null,
        public ?int $duration = null,
        public bool $filler = false,
        public bool $recap = false,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromJikanArray(array $data, int $number): self
    {
        return new self(
            malId: $data['mal_id'] ?? 0,
            number: $number,
            title: self::normalizeTitle($data['title'] ?? null) ?? 'Episode ' . $number,
            titleJa: self::normalizeTitle($data['title_japanese'] ?? null),
            titleRo: self::normalizeTitle($data['title_romanji'] ?? null),
            synopsis: null,
            aired: isset($data['aired']) ? Carbon::parse($data['aired']) : null,
            duration: isset($data['duration']) ? (int) round($data['duration'] / 60) : null,
            filler: $data['filler'] ?? false,
            recap: $data['recap'] ?? false,
        );
    }

    private static function normalizeTitle(?string $title): ?string
    {
        if ($title === null) {
            return null;
        }

        $normalized = trim(str_replace("\u{00A0}", '', $title));

        return $normalized !== '' ? $normalized : null;
    }
}
