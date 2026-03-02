<?php

namespace Tests\Feature\Filament;

use App\Enums\ThemeType;
use App\Filament\Resources\Themes\Pages\CreateTheme;
use App\Filament\Resources\Themes\Pages\EditTheme;
use App\Filament\Resources\Themes\Pages\ListThemes;
use App\Filament\Resources\Themes\Pages\ViewTheme;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ThemeResourceTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    public function test_can_create_theme(): void
    {
        Livewire::test(CreateTheme::class)
            ->fillForm([
                'mal_title' => 'Mecha',
                'name' => 'Mecha',
                'type' => ThemeType::Element->value,
            ])
            ->call('create')
            ->assertNotified()
            ->assertRedirect();

        $this->assertDatabaseHas(Theme::class, [
            'mal_title' => 'Mecha',
            'name' => 'Mecha',
            'type' => ThemeType::Element->value,
        ]);
    }

    public function test_can_update_theme(): void
    {
        $theme = Theme::factory()->create();

        Livewire::test(EditTheme::class, ['record' => $theme->id])
            ->fillForm([
                'name' => 'Updated Theme',
            ])
            ->call('save')
            ->assertNotified();

        $this->assertDatabaseHas(Theme::class, [
            'id' => $theme->id,
            'name' => 'Updated Theme',
        ]);
    }

    public function test_create_page_renders(): void
    {
        Livewire::test(CreateTheme::class)
            ->assertOk();
    }

    public function test_create_validates_required_fields(): void
    {
        Livewire::test(CreateTheme::class)
            ->fillForm([
                'mal_title' => null,
                'name' => null,
                'type' => null,
            ])
            ->call('create')
            ->assertHasFormErrors([
                'mal_title' => 'required',
                'name' => 'required',
                'type' => 'required',
            ])
            ->assertNotNotified();
    }

    public function test_edit_page_renders(): void
    {
        $theme = Theme::factory()->create();

        Livewire::test(EditTheme::class, ['record' => $theme->id])
            ->assertOk();
    }

    public function test_list_page_renders(): void
    {
        Theme::factory()->count(3)->create();

        Livewire::test(ListThemes::class)
            ->assertOk();
    }

    public function test_view_page_renders(): void
    {
        $theme = Theme::factory()->create();

        Livewire::test(ViewTheme::class, ['record' => $theme->id])
            ->assertOk();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($this->admin);
    }
}
