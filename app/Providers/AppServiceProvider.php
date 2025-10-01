<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use App\Models\Setting as SystemSettings;

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
    public function boot()
    {
        Paginator::useBootstrap();
                try {
            // Retrieve settings from DB
            $settings = SystemSettings::all()->pluck('value', 'key')->toArray();
            Config::set([
                'stripe.key' => $settings['stripe_publishable_key'] ?? null,
                'stripe.secret' => $settings['stripe_secret_key'] ?? null,
            ]);

        } catch (\Throwable $th) {
            // Handle exceptions silently
        }
    }
}
