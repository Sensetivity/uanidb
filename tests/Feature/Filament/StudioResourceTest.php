<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\Studios\Pages\CreateStudio;
use App\Filament\Resources\Studios\Pages\EditStudio;
use App\Filament\Resources\Studios\Pages\ListStudios;
use App\Filament\Resources\Studios\Pages\ViewStudio;
use App\Models\Studio;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class StudioResourceTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    public function test_can_create_studio(): void
    {
        Livewire::test(CreateStudio::class)
            ->fillForm([
                'name' => 'Studio Ghibli',
            ])
            ->call('create')
            ->assertNotified()
            ->assertRedirect();

        $this->assertDatabaseHas(Studio::class, [
            'name' => 'Studio Ghibli',
        ]);
    }

    public function test_can_update_studio(): void
    {
        $studio = Studio::factory()->create();

        Livewire::test(EditStudio::class, ['record' => $studio->id])
            ->fillForm([
                'name' => 'Updated Studio',
            ])
            ->call('save')
            ->assertNotified();

        $this->assertDatabaseHas(Studio::class, [
            'id' => $studio->id,
            'name' => 'Updated Studio',
        ]);
    }

    public function test_create_page_renders(): void
    {
        Livewire::test(CreateStudio::class)
            ->assertOk();
    }

    public function test_create_validates_required_fields(): void
    {
        Livewire::test(CreateStudio::class)
            ->fillForm([
                'name' => null,
            ])
            ->call('create')
            ->assertHasFormErrors(['name' => 'required'])
            ->assertNotNotified();
    }

    public function test_edit_page_renders(): void
    {
        $studio = Studio::factory()->create();

        Livewire::test(EditStudio::class, ['record' => $studio->id])
            ->assertOk();
    }

    public function test_list_page_renders(): void
    {
        Studio::factory()->count(3)->create();

        Livewire::test(ListStudios::class)
            ->assertOk();
    }

    public function test_view_page_renders(): void
    {
        $studio = Studio::factory()->create();

        Livewire::test(ViewStudio::class, ['record' => $studio->id])
            ->assertOk();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($this->admin);
    }
}
