<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImportThemesCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_fails_on_invalid_json(): void
    {
        $filePath = storage_path('app/test_invalid_themes.json');
        file_put_contents($filePath, '{broken');

        try {
            $this->artisan('import:themes', ['file' => $filePath])
                ->expectsOutputToContain('Invalid JSON')
                ->assertExitCode(1);
        } finally {
            @unlink($filePath);
        }
    }

    public function test_fails_when_default_file_not_found(): void
    {
        $defaultPath = storage_path('app/dump/themes.json');

        if (file_exists($defaultPath)) {
            $this->markTestSkipped('Default themes dump exists on disk.');
        }

        $this->artisan('import:themes')
            ->expectsOutputToContain('File not found')
            ->assertExitCode(1);
    }

    public function test_fails_when_file_not_found(): void
    {
        $this->artisan('import:themes', ['file' => '/nonexistent/themes.json'])
            ->expectsOutputToContain('File not found')
            ->assertExitCode(1);
    }
}
