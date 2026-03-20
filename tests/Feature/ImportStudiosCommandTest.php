<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImportStudiosCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_fails_on_invalid_json(): void
    {
        $filePath = storage_path('app/test_invalid.json');
        file_put_contents($filePath, 'not valid json{{{');

        try {
            $this->artisan('import:studios', ['file' => $filePath])
                ->expectsOutputToContain('Invalid JSON')
                ->assertExitCode(1);
        } finally {
            @unlink($filePath);
        }
    }

    public function test_fails_when_default_file_not_found(): void
    {
        // Ensure default path doesn't exist
        $defaultPath = storage_path('app/dump/studios.json');

        if (file_exists($defaultPath)) {
            $this->markTestSkipped('Default studios dump exists on disk.');
        }

        $this->artisan('import:studios')
            ->expectsOutputToContain('File not found')
            ->assertExitCode(1);
    }

    public function test_fails_when_file_not_found(): void
    {
        $this->artisan('import:studios', ['file' => '/nonexistent/file.json'])
            ->expectsOutputToContain('File not found')
            ->assertExitCode(1);
    }
}
