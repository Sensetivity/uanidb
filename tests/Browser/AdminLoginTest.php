<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdminLoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Override trait's rollback behavior.
     *
     * migrate:fresh drops all tables at the start of each test, so rollback
     * is unnecessary. This avoids down() method issues with index constraints.
     */
    public function runDatabaseMigrations(): void
    {
        $this->artisan('migrate:fresh');

        $this->app[Kernel::class]->setArtisan(null);
    }

    public function test_admin_can_login(): void
    {
        $admin = User::factory()->admin()->create([
            'email' => 'admin@uanidb.local',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->visit('/admin/login')
                ->type('input[id="form.email"]', $admin->email)
                ->type('input[id="form.password"]', 'password')
                ->press('Увійти')
                ->waitForLocation('/admin')
                ->assertPathIs('/admin');
        });
    }

    public function test_admin_login_page_renders(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/login')
                ->assertSee('Електронна пошта')
                ->assertSee('Пароль')
                ->assertSee('Увійти');
        });
    }

    public function test_non_admin_cannot_login(): void
    {
        $user = User::factory()->create([
            'email' => 'user@uanidb.local',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/admin/login')
                ->type('input[id="form.email"]', $user->email)
                ->type('input[id="form.password"]', 'password')
                ->press('Увійти')
                ->pause(1000)
                ->assertPathIs('/admin/login');
        });
    }
}
