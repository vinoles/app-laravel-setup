<?php

namespace Tests\Browser\Filament;

use App\Constants\UserRole;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Filament\Login;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'ShieldSeeder']);

    }

    /**
     * A user can see the login page
     * @test
     */
    public function login_page(): void
    {
        $this->browse(function (Browser $browser) {
            $page = new Login;

            $browser->visit($page)
                ->waitForText(__('DOGME'))
                ->assertPresent('@email')
                ->assertPresent('@password')
                ->assertPresent('@submit')
                ->screenshot('login_page');
        });
    }

    /**
     * A user can see the login page and redirect to dashboard
     * @test
     */
    public function login_page_and_redirect_to_dashboard(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();

            $user->assignRole(UserRole::ADMIN);

            $page = new Login;

            $browser->visit($page)
                ->waitForText(__('DOGME'))
                ->assertPresent('@email')
                ->assertPresent('@password')
                ->assertPresent('@submit')
                ->submitSignInForm($user, 'password')
                ->waitForLink(__('admin.talents.talents'))
                ->assertSee(__('admin.talents.talents'))
                ->assertSee(__('admin.users.users'))
                ->pause(5000)
                ->screenshot('dashboard_page');
        });
    }
}
