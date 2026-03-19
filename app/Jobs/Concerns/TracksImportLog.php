<?php

namespace App\Jobs\Concerns;

use App\Enums\ImportJobTypeEnum;
use App\Enums\ImportStatusEnum;
use App\Models\Anime;
use App\Models\ImportLog;
use Illuminate\Support\Facades\Log;

trait TracksImportLog
{
    abstract protected function jobType(): ImportJobTypeEnum;

    protected function resolveAnimeOrSkip(int $animeId, ImportLog $importLog): ?Anime
    {
        $anime = Anime::query()->find($animeId);

        if (! $anime) {
            Log::warning(class_basename($this) . ": Anime ID {$animeId} not found.");
            $importLog->markAsCompleted();

            return null;
        }

        return $anime;
    }

    protected function runWithImportLog(?Anime $anime, \Closure $callback, ?int $malId = null): void
    {
        $jobName = class_basename($this);

        $importLog = ImportLog::query()->create([
            'job_type' => $this->jobType(),
            'anime_id' => $anime?->id,
            'mal_id' => $malId ?? $anime?->mal_id,
            'status' => ImportStatusEnum::Pending,
        ]);

        $importLog->markAsRunning();

        try {
            $callback($importLog);

            $importLog->markAsCompleted();
            $anime?->markAsSynced();
        } catch (\Throwable $e) {
            Log::error("{$jobName}: Failed — {$e->getMessage()}");
            $importLog->markAsFailed($e->getMessage());
            $anime?->markSyncFailed();

            throw $e;
        }
    }
}
