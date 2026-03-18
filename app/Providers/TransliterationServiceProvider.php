<?php

namespace App\Providers;

use App\Contracts\Services\Transliteration\TransliterationProvider;
use App\Services\Transliteration\Legacy\LegacyTransliterationProvider;
use App\Services\Transliteration\Providers\KovalenkoTransliterationProvider;
use App\Services\Transliteration\TransliterationService;
use Illuminate\Support\ServiceProvider;

class TransliterationServiceProvider extends ServiceProvider
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
        $this->app->bind(TransliterationProvider::class, function (): TransliterationProvider {
            $providerKey = rescue(
                fn () => \App\Models\Setting::get('transliteration_system', 'kovalenko'),
                'kovalenko',
                false,
            );

            return match ($providerKey) {
                'legacy' => new LegacyTransliterationProvider(),
                default => new KovalenkoTransliterationProvider(),
            };
        });

        $this->app->singleton(TransliterationService::class, function ($app): TransliterationService {
            return new TransliterationService(
                provider: $app->make(TransliterationProvider::class),
            );
        });
    }
}
