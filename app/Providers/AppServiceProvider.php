<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

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
        // Custom route rule for outward facing images, this allow the end user to appnd all kinds of
        // extensions to the image id and they will stilll get a valid image file returned.
        Route::bind('oimg', function ($val) {
            return \App\Models\Img::where('oid', substr($val, 0, 8))->firstOrFail();
        });
    }
}
