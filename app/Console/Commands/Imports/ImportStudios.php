<?php

namespace App\Console\Commands\Imports;

use App\Models\Studio;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportStudios extends Command
{
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import studios data from JSON file';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:studios {file? : Path to JSON file}';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the file path from the command argument or use default
        $filePath = $this->argument('file') ?? storage_path('app/dump/studios.json');

        // Check if file exists
        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");

            return 1;
        }

        // Read and decode JSON file
        $jsonContent = file_get_contents($filePath);
        $studios = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('Invalid JSON file: ' . json_last_error_msg());

            return 1;
        }

        $this->info('Starting import of ' . count($studios) . ' studios...');

        $bar = $this->output->createProgressBar(count($studios));
        $bar->start();

        $imported = 0;
        $errors = 0;

        DB::beginTransaction();

        try {
            foreach ($studios as $studioData) {
                try {
                    // Find existing studio or create new one
                    $studio = Studio::updateOrCreate(
                        ['mal_id' => $studioData['id']],
                        [
                            'name' => $studioData['name'],
                            // Add any other fields from your JSON here
                        ]
                    );

                    $imported++;
                } catch (\Exception $e) {
                    $this->newLine();
                    $this->warn("Error importing studio {$studioData['name']}: " . $e->getMessage());
                    $errors++;
                }

                $bar->advance();
            }

            DB::commit();

            $bar->finish();
            $this->newLine(2);
            $this->info("Import completed: {$imported} studios imported successfully.");

            if ($errors > 0) {
                $this->warn("{$errors} studios had errors during import.");
            }

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Import failed: ' . $e->getMessage());

            return 1;
        }

        return 0;
    }
}
