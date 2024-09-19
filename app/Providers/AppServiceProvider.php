<?php

namespace App\Providers;

use App\Models\Talent;
use App\Policies\TalentPolicy;
use Illuminate\Support\ServiceProvider;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Illuminate\Support\Facades\Gate;

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
        // Gate::policy(Talent::class, TalentPolicy::class);

        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['es','en','fr'])
                ->labels([
                    'es' => __('admin.locales.es'),
                    'en' => __('admin.locales.en'),
                    'fr' => __('admin.locales.fr'),
                ]);
        });
    }
}
