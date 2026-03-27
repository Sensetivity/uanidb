<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Studio;
use App\Models\Theme;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CatalogSeeder extends Seeder
{
    /**
     * Seed genres, themes and studios from JSON dumps.
     */
    public function run(): void
    {
        $this->seedGenres();
        $this->seedThemes();
        $this->seedStudios();
    }

    private function seedGenres(): void
    {
        $path = storage_path('app/dump/genre.json');

        if (! File::exists($path)) {
            $this->command->warn('genre.json not found, skipping.');

            return;
        }

        $items = json_decode(File::get($path), true);
        $created = 0;
        $updated = 0;

        foreach ($items as $item) {
            $malTitle = trim($item['title']);
            $nameUk = trim($item['title_uk']);

            if ($malTitle === '' && $nameUk === '') {
                continue;
            }

            // Try to match existing genre by mal_title
            $genre = null;
            if ($malTitle !== '') {
                $genre = Genre::query()->where('mal_title', $malTitle)->first();
            }

            if ($genre) {
                $genre->update(['name' => $nameUk]);
                $updated++;
            } else {
                Genre::query()->firstOrCreate(
                    ['name' => $nameUk],
                    ['mal_title' => $malTitle ?: $nameUk],
                );
                $created++;
            }
        }

        $this->command->info("Genres: {$created} created, {$updated} updated.");
    }

    private function seedStudios(): void
    {
        $path = storage_path('app/dump/studios.json');

        if (! File::exists($path)) {
            $this->command->warn('studios.json not found, skipping.');

            return;
        }

        $items = json_decode(File::get($path), true);
        $created = 0;
        $updated = 0;

        foreach ($items as $item) {
            $malId = (int) $item['id'];
            $name = trim($item['name']);

            if ($name === '') {
                continue;
            }

            $sourceLogoUrl = trim($item['source_logo_url'] ?? '');

            $studio = Studio::query()->where('mal_id', $malId)->first();

            if ($studio) {
                $data = ['name' => $name];
                if ($sourceLogoUrl !== '') {
                    $data['source_logo_url'] = $sourceLogoUrl;
                }
                $studio->update($data);
                $updated++;
            } else {
                Studio::query()->create([
                    'mal_id' => $malId,
                    'name' => $name,
                    'source_logo_url' => $sourceLogoUrl ?: null,
                ]);
                $created++;
            }
        }

        $this->command->info("Studios: {$created} created, {$updated} updated.");
    }

    private function seedThemes(): void
    {
        $path = storage_path('app/dump/themes.json');

        if (! File::exists($path)) {
            $this->command->warn('themes.json not found, skipping.');

            return;
        }

        $items = json_decode(File::get($path), true);
        $created = 0;
        $updated = 0;

        foreach ($items as $item) {
            $malTitle = trim($item['title']);
            $nameUk = trim($item['title_uk']);
            $type = (int) $item['type'];
            $description = trim($item['description'] ?? '');

            $theme = Theme::query()->where('mal_title', $malTitle)->first();

            if ($theme) {
                $theme->update([
                    'name' => $nameUk,
                    'type' => $type,
                    'description' => $description ?: null,
                ]);
                $updated++;
            } else {
                Theme::query()->firstOrCreate(
                    ['mal_title' => $malTitle],
                    [
                        'name' => $nameUk,
                        'type' => $type,
                        'description' => $description ?: null,
                    ],
                );
                $created++;
            }
        }

        $this->command->info("Themes: {$created} created, {$updated} updated.");
    }
}
