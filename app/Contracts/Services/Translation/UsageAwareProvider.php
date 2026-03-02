<?php

namespace App\Contracts\Services\Translation;

use App\Services\Translation\TranslationUsage;

interface UsageAwareProvider extends TranslationProvider
{
    /**
     * Get the API usage for the current billing period.
     */
    public function getUsage(): TranslationUsage;
}
