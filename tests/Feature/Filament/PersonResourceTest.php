<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\People\Pages\CreatePerson;
use App\Filament\Resources\People\Pages\EditPerson;
use App\Filament\Resources\People\Pages\ListPeople;
use App\Filament\Resources\People\Pages\ViewPerson;
use App\Models\Person;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PersonResourceTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    public function test_can_create_person(): void
    {
        Livewire::test(CreatePerson::class)
            ->fillForm([
                'name' => 'Hayao Miyazaki',
            ])
            ->call('create')
            ->assertNotified()
            ->assertRedirect();

        $this->assertDatabaseHas(Person::class, [
            'name' => 'Hayao Miyazaki',
        ]);
    }

    public function test_can_update_person(): void
    {
        $person = Person::factory()->create();

        Livewire::test(EditPerson::class, ['record' => $person->id])
            ->fillForm([
                'name' => 'Updated Person',
            ])
            ->call('save')
            ->assertNotified();

        $this->assertDatabaseHas(Person::class, [
            'id' => $person->id,
            'name' => 'Updated Person',
        ]);
    }

    public function test_create_page_renders(): void
    {
        Livewire::test(CreatePerson::class)
            ->assertOk();
    }

    public function test_create_validates_required_fields(): void
    {
        Livewire::test(CreatePerson::class)
            ->fillForm([
                'name' => null,
            ])
            ->call('create')
            ->assertHasFormErrors(['name' => 'required'])
            ->assertNotNotified();
    }

    public function test_edit_page_renders(): void
    {
        $person = Person::factory()->create();

        Livewire::test(EditPerson::class, ['record' => $person->id])
            ->assertOk();
    }

    public function test_list_page_renders(): void
    {
        Person::factory()->count(3)->create();

        Livewire::test(ListPeople::class)
            ->assertOk();
    }

    public function test_view_page_renders(): void
    {
        $person = Person::factory()->create();

        Livewire::test(ViewPerson::class, ['record' => $person->id])
            ->assertOk();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->actingAs($this->admin);
    }
}
