<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use App\Http\Resources\{ProfileResource,PostResource,PostCollection,ProfileCollection};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   
        ProfileResource::withoutWrapping();
        PostCollection::withoutWrapping();
        if (!App::environment('local')) {
            \URL::forceScheme('http');
        }
    }
}
