<?php

namespace RamzyVirani\RateAndReview;

use Illuminate\Support\ServiceProvider;

class RateAndReviewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/routes.php');

        // Package consumers should create another migration to update our migrations.
        $this->loadMigrationsFrom(__DIR__ . '/migrations');

        $this->loadViewsFrom(__DIR__ . '/views/rateandreview', 'rateandreview');

        // Views and Config files so that user can migrate, modify the config and view files.
        $this->publishes([
            __DIR__ . '/views/rateandreview' => resource_path('views/vendor/rateandreview'),
            __DIR__ . '/config/config.php'   => config_path('rateandreview.php'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/config.php', 'rateandreview'
        );
    }
}
