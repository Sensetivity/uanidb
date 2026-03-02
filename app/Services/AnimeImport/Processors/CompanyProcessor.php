<?php

namespace App\Services\AnimeImport\Processors;

use App\Dto\AnimeFullDto;
use App\Dto\MalEntryDto;
use App\Models\Anime;
use App\Models\Studio;

class CompanyProcessor implements RelationProcessor
{
    public function sync(Anime $anime, AnimeFullDto $dto): void
    {
        $this->attachCompanies($anime, $dto->anime->studios, 'studios', [
            'role' => 'studio',
            'is_main' => true,
        ]);

        $this->attachCompanies($anime, $dto->anime->producers, 'producers', [
            'role' => 'producer',
        ]);

        $this->attachCompanies($anime, $dto->anime->licensors, 'licensors', [
            'region' => 'global',
        ]);
    }

    public function clear(Anime $anime): void
    {
        $anime->studios()->detach();
        $anime->producers()->detach();
        $anime->licensors()->detach();
    }

    /**
     * @param array<MalEntryDto> $companies
     * @param array<string, mixed> $pivotDefaults
     */
    private function attachCompanies(Anime $anime, array $companies, string $relation, array $pivotDefaults = []): void
    {
        if (empty($companies)) {
            return;
        }

        $pivotData = [];

        foreach ($companies as $index => $companyData) {
            $company = Studio::query()->firstOrCreate(
                ['mal_id' => $companyData->malId],
                ['name' => $companyData->name],
            );

            $pivot = ['order' => $index];

            if (isset($pivotDefaults['role'])) {
                $pivot['role'] = $pivotDefaults['role'];
            }

            if (isset($pivotDefaults['region'])) {
                $pivot['region'] = $pivotDefaults['region'];
            }

            if (isset($pivotDefaults['is_main'])) {
                $pivot['is_main'] = $index === 0;
            }

            $pivotData[$company->id] = $pivot;
        }

        $anime->{$relation}()->sync($pivotData);
    }
}
