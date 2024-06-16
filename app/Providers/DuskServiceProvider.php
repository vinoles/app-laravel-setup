<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\Browser;

class DuskServiceProvider extends ServiceProvider
{
    /**
     * Register Dusk's browser macros.
     */
    public function boot(): void
    {
        Browser::macro('scrollToElement', function (string $element = null) {
            $this->script("$('html, body').animate({ scrollTop: $('$element').offset().top }, 0);");

            return $this;
        });

        Browser::macro(
            'submitSignInForm',
            function (User $user, string $password) {
                return $this->type('@email', $user->email)
                    ->type('@password', $password)
                    ->screenshot('fill_login_page')
                    ->pause(2000)
                    ->press('@submit');
            }
        );
    }
}
