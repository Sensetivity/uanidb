<?php

namespace App\Services\Translation;

use App\Contracts\Services\Translation\TranslationProvider;
use App\Contracts\Services\Translation\UsageAwareProvider;
use App\Models\Anime;
use App\Models\Episode;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    public function __construct(
        private TranslationProvider $provider,
        private string              $targetLanguage = 'UK',
    ) {}

    /**
     * Get API usage for the current billing period.
     * Returns zeros if the active provider does not support usage reporting.
     */
    public function getUsage(): TranslationUsage
    {
        if ($this->provider instanceof UsageAwareProvider) {
            return $this->provider->getUsage();
        }

        return new TranslationUsage(characterCount: 0, characterLimit: 0);
    }

    /**
     * Translate a single text string.
     */
    public function translate(string $text, ?string $targetLanguage = null): ?string
    {
        $text = trim($text);

        if ($text === '') {
            return null;
        }

        $targetLang = $targetLanguage ?? $this->targetLanguage;
        $cacheKey = $this->cacheKey($text, $targetLang);

        return Cache::remember($cacheKey, now()->addMonth(), fn () => $this->provider->translate($text, $targetLang));
    }

    /**
     * Translate anime synopsis to Ukrainian.
     */
    public function translateAnimeSynopsis(Anime $anime): bool
    {
        if (empty($anime->synopsis)) {
            return false;
        }

        if (! empty($anime->synopsis_uk)) {
            return false;
        }

        $translated = $this->translate($anime->synopsis);

        if ($translated === null) {
            return false;
        }

        $anime->update(['synopsis_uk' => $translated]);

        Log::info("Translated synopsis for anime: {$anime->title} (ID: {$anime->id})");

        return true;
    }

    /**
     * Translate multiple texts, using cache to avoid redundant API calls.
     *
     * @param  array<string>  $texts
     * @return array<string|null>
     */
    public function translateBatch(array $texts, ?string $targetLanguage = null): array
    {
        $targetLang = $targetLanguage ?? $this->targetLanguage;

        $indexMap = [];
        $textsToTranslate = [];
        $results = array_fill(0, count($texts), null);

        foreach (array_values($texts) as $index => $text) {
            $trimmed = trim($text);

            if ($trimmed === '') {
                continue;
            }

            $cacheKey = $this->cacheKey($trimmed, $targetLang);
            $cached = Cache::get($cacheKey);

            if ($cached !== null) {
                $results[$index] = $cached;
            } else {
                $indexMap[] = $index;
                $textsToTranslate[] = $trimmed;
            }
        }

        if ($textsToTranslate === []) {
            return $results;
        }

        $apiResults = $this->provider->translateBatch($textsToTranslate, $targetLang);

        foreach ($apiResults as $i => $translatedText) {
            $originalIndex = $indexMap[$i];
            $results[$originalIndex] = $translatedText;

            $cacheKey = $this->cacheKey($textsToTranslate[$i], $targetLang);
            Cache::put($cacheKey, $translatedText, now()->addMonth());
        }

        return $results;
    }

    /**
     * Translate episode title and synopsis to Ukrainian.
     */
    public function translateEpisode(Episode $episode): bool
    {
        $updated = false;
        $data = [];

        $titleSource = $episode->title_en ?? $episode->title;

        if (! empty($titleSource) && empty($episode->title_uk)) {
            $translated = $this->translate($titleSource);

            if ($translated !== null) {
                $data['title_uk'] = $translated;
                $updated = true;
            }
        }

        if (! empty($episode->synopsis) && empty($episode->synopsis_uk)) {
            $translated = $this->translate($episode->synopsis);

            if ($translated !== null) {
                $data['synopsis_uk'] = $translated;
                $updated = true;
            }
        }

        if ($updated) {
            $episode->update($data);
            Log::info("Translated anime episode: {$episode->anime_id} ep.{$episode->number}");
        }

        return $updated;
    }

    /**
     * Generate a cache key for a translation.
     */
    private function cacheKey(string $text, string $targetLang): string
    {
        return 'translation_' . $targetLang . '_' . md5($text);
    }
}
