<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Spanish, English, French
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['es','en','fr']) // also accepts a closure
                ->labels([
                    'es' => __('admin.locales.es'),
                    'en' => __('admin.locales.en'),
                    'fr' => __('admin.locales.fr'),
                    // Other custom labels as needed
                ]);
        });
    }
}
