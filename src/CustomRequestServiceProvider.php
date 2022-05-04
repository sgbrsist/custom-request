<?php

namespace Sgbrsist\CustomRequest;

use Illuminate\Support\ServiceProvider;

class CustomRequestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            CustomRequestInterface::class,
            CustomRequest::class
        );

        $this->app->bind(
            CustomRequestResponseInterface::class,
            CustomRequestResponse::class
        );
    }
}
