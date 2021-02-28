<?php

namespace Jas\Providers;

use Illuminate\Support\ServiceProvider;
use Jas\Interfaces\ContactRepository;
use Jas\Interfaces\PersonRepository;
use Jas\Repositories\ContactRepositoryEloquent;
use Jas\Repositories\PersonRepositoryEloquent;

class RepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(PersonRepository::class, PersonRepositoryEloquent::class);
        $this->app->bind(ContactRepository::class, ContactRepositoryEloquent::class);
        //:end-bindings:
    }
}
