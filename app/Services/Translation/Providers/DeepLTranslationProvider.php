<?php

namespace App\Services\Translation\Providers;

use App\Contracts\Services\Translation\UsageAwareProvider;
use App\Services\Translation\TranslationUsage;
use DeepL\DeepLClient;
use DeepL\TooManyRequestsException;

class DeepLTranslationProvider implements UsageAwareProvider
{
    private const RETRY_DELAYS = [5, 15, 30];

    private DeepLClient $translator;

    public function __construct(string $apiKey)
    {
        $this->translator = new DeepLClient($apiKey);
    }

    /**
     * Get the DeepL API usage for the current billing period.
     */
    public function getUsage(): TranslationUsage
    {
        $usage = $this->translator->getUsage();

        return new TranslationUsage(
            characterCount: $usage->character->count ?? 0,
            characterLimit: $usage->character->limit ?? 0,
        );
    }

    /**
     * Translate a single text string via DeepL.
     */
    public function translate(string $text, string $targetLang): ?string
    {
        $result = $this->withRetry(fn () => $this->translator->translateText($text, null, $targetLang));

        return $result->text;
    }

    /**
     * Translate multiple texts in a single DeepL API call.
     *
     * @param  array<string>  $texts
     * @return array<string|null>
     */
    public function translateBatch(array $texts, string $targetLang): array
    {
        $results = $this->withRetry(fn () => $this->translator->translateText($texts, null, $targetLang));

        return array_map(fn ($result) => $result->text, $results);
    }

    /**
     * Execute a callable with automatic retry on TooManyRequestsException.
     *
     * @template T
     *
     * @param  callable(): T  $callback
     * @return T
     *
     * @throws TooManyRequestsException
     */
    private function withRetry(callable $callback): mixed
    {
        $delays = self::RETRY_DELAYS;

        while (true) {
            try {
                return $callback();
            } catch (TooManyRequestsException $e) {
                if ($delays === []) {
                    throw $e;
                }

                sleep(array_shift($delays));
            }
        }
    }
}
