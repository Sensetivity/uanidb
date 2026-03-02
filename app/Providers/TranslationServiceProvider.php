<?php

namespace App\Providers;

use App\Contracts\Services\Translation\TranslationProvider;
use App\Services\Translation\Providers\DeepLTranslationProvider;
use App\Services\Translation\TranslationService;
use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TranslationProvider::class, function (): TranslationProvider {
            $providerKey = rescue(
                fn () => \App\Models\Setting::get('translation_provider', 'deepl'),
                'deepl',
                false,
            );

            return match ($providerKey) {
                default => new DeepLTranslationProvider(
                    apiKey: (string) config('services.deepl.api_key'),
                ),
            };
        });

        $this->app->singleton(TranslationService::class, function ($app): TranslationService {
            $targetLanguage = rescue(
                fn () => \App\Models\Setting::get('target_language', 'UK'),
                'UK',
                false,
            );

            return new TranslationService(
                provider: $app->make(TranslationProvider::class),
                targetLanguage: (string) ($targetLanguage ?? config('services.deepl.target_language', 'UK')),
            );
        });
    }
}
