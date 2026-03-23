<?php

namespace Tests\Feature\Filament;

use App\Filament\Actions\BatchImportFromMalAction;
use App\Filament\Actions\ImportFromMalAction;
use App\Filament\Resources\Animes\Pages\ListAnimes;
use App\Jobs\ImportAnimeJob;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Livewire\Livewire;
use Tests\TestCase;

class ImportFromMalActionTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    public function test_batch_import_action_is_visible(): void
    {
        Livewire::test(ListAnimes::class)
            ->assertActionVisible('batch_import_from_mal');
    }

    public function test_batch_import_deduplicates_ids(): void
    {
        Bus::fake(ImportAnimeJob::class);

        Livewire::test(ListAnimes::class)
            ->callAction(BatchImportFromMalAction::class, data: ['mal_ids' => '1, 1, 5'])
            ->assertNotified();

        Bus::assertDispatchedTimes(ImportAnimeJob::class, 2);
    }

    public function test_batch_import_dispatches_jobs_for_valid_ids(): void
    {
        Bus::fake(ImportAnimeJob::class);

        Livewire::test(ListAnimes::class)
            ->callAction(BatchImportFromMalAction::class, data: ['mal_ids' => '1, 5, 21'])
            ->assertNotified();

        Bus::assertDispatchedTimes(ImportAnimeJob::class, 3);
    }

    public function test_batch_import_filters_invalid_keeps_valid(): void
    {
        Bus::fake(ImportAnimeJob::class);

        Livewire::test(ListAnimes::class)
            ->callAction(BatchImportFromMalAction::class, data: ['mal_ids' => '1, abc, 5, -1'])
            ->assertNotified();

        Bus::assertDispatchedTimes(ImportAnimeJob::class, 2);
    }

    public function test_batch_import_requires_mal_ids(): void
    {
        Bus::fake(ImportAnimeJob::class);

        Livewire::test(ListAnimes::class)
            ->callAction(BatchImportFromMalAction::class, data: ['mal_ids' => null])
            ->assertHasFormErrors(['mal_ids' => 'required']);

        Bus::assertNotDispatched(ImportAnimeJob::class);
    }

    public function test_batch_import_shows_error_for_all_invalid_ids(): void
    {
        Bus::fake(ImportAnimeJob::class);

        Livewire::test(ListAnimes::class)
            ->callAction(BatchImportFromMalAction::class, data: ['mal_ids' => 'abc, -1, 0'])
            ->assertNotified();

        Bus::assertNotDispatched(ImportAnimeJob::class);
    }

    public function test_import_from_mal_action_is_visible(): void
    {
        Livewire::test(ListAnimes::class)
            ->assertActionVisible('import_from_mal');
    }

    public function test_import_from_mal_dispatches_job(): void
    {
        Bus::fake(ImportAnimeJob::class);

        Livewire::test(ListAnimes::class)
            ->callAction(ImportFromMalAction::class, data: ['mal_id' => 12345])
            ->assertNotified();

        Bus::assertDispatched(ImportAnimeJob::class);
    }

    public function test_import_from_mal_requires_mal_id(): void
    {
        Bus::fake(ImportAnimeJob::class);

        Livewire::test(ListAnimes::class)
            ->callAction(ImportFromMalAction::class, data: ['mal_id' => null])
            ->assertHasFormErrors(['mal_id' => 'required']);

        Bus::assertNotDispatched(ImportAnimeJob::class);
    }

    public function test_import_from_mal_requires_numeric_mal_id(): void
    {
        Bus::fake(ImportAnimeJob::class);

        Livewire::test(ListAnimes::class)
            ->callAction(ImportFromMalAction::class, data: ['mal_id' => 'abc'])
            ->assertHasFormErrors(['mal_id' => 'numeric']);

        Bus::assertNotDispatched(ImportAnimeJob::class);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->actingAs($this->admin);
    }
}
