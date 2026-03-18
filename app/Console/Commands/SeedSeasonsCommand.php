<?php

namespace App\Console\Commands;

use App\Enums\SeasonOfYearEnum;
use App\Models\Season;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SeedSeasonsCommand extends Command
{
    protected $description = 'Seed the seasons table with all Winter/Spring/Summer/Fall seasons';
    protected $signature = 'seasons:seed
                            {--from=1960 : First year to generate}
                            {--to=      : Last year to generate (default: next year)}';

    public function handle(): int
    {
        $fromYear = (int) $this->option('from');
        $toYear   = (int) ($this->option('to') ?: Carbon::now()->addYear()->year);

        if ($fromYear > $toYear) {
            $this->error("--from ({$fromYear}) must be less than or equal to --to ({$toYear}).");

            return self::FAILURE;
        }

        [$currentYear, $currentSeason] = $this->resolveCurrentSeason();

        // Reset is_current on all existing seasons first
        DB::table('seasons')->where('is_current', true)->update(['is_current' => false]);

        $created = 0;
        $updated = 0;

        for ($year = $fromYear; $year <= $toYear; $year++) {
            foreach (self::seasons() as $meta) {
                $enum      = $meta['enum'];
                $isCurrent = ($year === $currentYear && $enum === $currentSeason);

                $season = Season::query()->updateOrCreate(
                    ['year' => $year, 'season_of_year' => $enum],
                    [
                        'start_date' => "{$year}-{$meta['start']}",
                        'end_date'   => "{$year}-{$meta['end']}",
                        'is_current' => $isCurrent,
                    ],
                );

                $season->wasRecentlyCreated ? $created++ : $updated++;
            }
        }

        $total = ($toYear - $fromYear + 1) * 4;

        $this->info("Done. {$total} seasons processed ({$created} created, {$updated} updated).");
        $this->line("  Current season: <comment>{$currentSeason->name} {$currentYear}</comment>");

        return self::SUCCESS;
    }

    /**
     * @return array{int, SeasonOfYearEnum}
     */
    private function resolveCurrentSeason(): array
    {
        $now   = Carbon::now();
        $month = $now->month;

        $season = match (true) {
            $month <= 3  => SeasonOfYearEnum::Winter,
            $month <= 6  => SeasonOfYearEnum::Spring,
            $month <= 9  => SeasonOfYearEnum::Summer,
            default      => SeasonOfYearEnum::Fall,
        };

        return [$now->year, $season];
    }

    /** @return array<int, array{enum: SeasonOfYearEnum, start: string, end: string}> */
    private static function seasons(): array
    {
        return [
            ['enum' => SeasonOfYearEnum::Winter, 'start' => '01-01', 'end' => '03-31'],
            ['enum' => SeasonOfYearEnum::Spring, 'start' => '04-01', 'end' => '06-30'],
            ['enum' => SeasonOfYearEnum::Summer, 'start' => '07-01', 'end' => '09-30'],
            ['enum' => SeasonOfYearEnum::Fall,   'start' => '10-01', 'end' => '12-31'],
        ];
    }
}
