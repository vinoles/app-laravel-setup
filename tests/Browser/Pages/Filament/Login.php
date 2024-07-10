<?php

namespace Tests\Browser\Pages\Filament;

use Laravel\Dusk\Browser;
use Tests\Browser\Pages\Page;

class Login extends Page
{
    /**
     * Get the URL for the page.
     */
    public function url(): string
    {
        return route('filament.admin.auth.login');

    }

    /**
     * Assert that the browser is on the page.
     */
    public function assert(Browser $browser): void
    {
        $browser->assertUrlIs($this->url());
    }

}
