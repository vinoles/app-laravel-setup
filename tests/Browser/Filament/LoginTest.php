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
        $page = new Login();

        $this->browse(function (Browser $browser) use ($page) {

            $browser->visit($page)
                ->waitForText(__('APP'))
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
        $user = User::factory()->create();

        $user->assignRole(UserRole::ADMIN);

        $page = new Login();

        $this->browse(function (Browser $browser) use ($page, $user) {

            $browser->visit($page)
                ->waitForText(__('APP'))
                ->assertPresent('@email')
                ->assertPresent('@password')
                ->assertPresent('@submit')
                ->loginAs($user);
        });
    }
}
