<?php

namespace Jas\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Jas\Validators\ValidatorExtended;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /*if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
        }*/
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Validator::resolver(function ($translator, $data, $rules, $messages = [], $customAttributes = []) {
            return new ValidatorExtended($translator, $data, $rules, $messages, $customAttributes);
        });

        Validator::extend('uuid', function ($attribute, $value, $parameters, $validator) {
            return Str::isUuid($value);
        });

        if (App::environment(['production'])) {
            URL::forceScheme('https');
        }
    }
}
