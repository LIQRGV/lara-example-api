<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Models\ContactOwner::class => \App\Policies\ContactOwnerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // add custom guard provider
        Auth::provider('header_user_provider', function ($app, array $config) {
            return new \App\Extensions\HeaderUserProvider($app->make(\App\Models\ContactOwner::class));
        });

        // add custom guard
        Auth::extend('header_guard', function ($app, $name, array $config) {
            return new \App\Services\Auth\HeaderGuard(Auth::createUserProvider($config['provider']), $app->make('request'));
        });
    }
}
