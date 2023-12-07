<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Actions\Hande;
use App\Actions\Hande2;

class CustomServicePrivider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(Hande2::class, function () {

            return new Hande2(now());

        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
