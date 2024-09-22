<?php

namespace Tests\Browser\Pages;

use Illuminate\Support\Str;
use Laravel\Dusk\Page as BasePage;

abstract class Page extends BasePage
{
    public function getRoute($name, $parameters = [])
    {
        $route = route(
            $name,
            $parameters,
        );

        return $route;
        //  Str::replace(
        //     'http://app-laravel-setup.test',
        //     'https://nginx',
        //     $route,
        // );
    }

    /**
     * Get the global element shortcuts for the site.
     *
     * @return array
     */
    public static function siteElements()
    {
        return [
            '@email' => 'input[type="email"]',
            '@password' => 'input[type="password"]',
            '@submit' => 'button[type="submit"]',
        ];
    }
}
