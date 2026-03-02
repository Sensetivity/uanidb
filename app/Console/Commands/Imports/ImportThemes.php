<?php

namespace App\Console\Commands\Imports;

use App\Models\Theme;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportThemes extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import themes data from JSON file';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:themes {file? : Path to JSON file}';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the file path from the command argument or use default
        $filePath = $this->argument('file') ?? storage_path('app/dump/themes.json');

        // Check if file exists
        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");

            return 1;
        }

        // Read and decode JSON file
        $jsonContent = file_get_contents($filePath);
        $themes = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('Invalid JSON file: ' . json_last_error_msg());

            return 1;
        }

        $this->info('Starting import of ' . count($themes) . ' themes...');

        $bar = $this->output->createProgressBar(count($themes));
        $bar->start();

        $imported = 0;
        $errors = 0;

        DB::beginTransaction();

        try {
            foreach ($themes as $theme) {
                try {
                    // Find existing studio or create new one
                    $theme = Theme::updateOrCreate(
                        ['mal_title' => $theme['title']],
                        [
                            'mal_title' => $theme['title'],
                            'name' => $theme['title_uk'],
                            'type' => $theme['type'],
                            'description' => $theme['description'],
                        ]
                    );

                    $imported++;
                } catch (\Exception $e) {
                    $this->newLine();
                    $this->warn("Error importing studio {$theme['title']}: " . $e->getMessage());
                    $errors++;
                }

                $bar->advance();
            }

            DB::commit();

            $bar->finish();
            $this->newLine(2);
            $this->info("Import completed: {$imported} themes imported successfully.");

            if ($errors > 0) {
                $this->warn("{$errors} themes had errors during import.");
            }

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Import failed: ' . $e->getMessage());

            return 1;
        }

        return 0;
    }
}
