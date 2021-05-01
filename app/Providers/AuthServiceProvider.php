<?php

namespace App\Providers;

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
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('VIEW_ADMIN', function ($user){
            return $user->canDo('VIEW_ADMIN', false);
        });

        Gate::define('EDIT_PERMISSIONS', function ($user){
            return $user->canDo('EDIT_PERMISSIONS', false);
        });

        Gate::define('ADMIN_USERS', function ($user){
            return $user->canDo('ADMIN_USERS', false);
        });

        Gate::define('ADVERTISER_COMPANIES', function ($user){
            return $user->canDo('ADVERTISER_COMPANIES', false);
        });

        Gate::define('RESTAURANT_COMPANIES', function ($user){
            return $user->canDo('RESTAURANT_COMPANIES', false);
        });

        Gate::define('INDUSTRIES_FOR_ADVERTISER_COMPANIES', function ($user){
            return $user->canDo('INDUSTRIES_FOR_ADVERTISER_COMPANIES', false);
        });

        Gate::define('ADD_DISH_FOR_RESTAURANTS', function ($user){
            return $user->canDo('ADD_DISH_FOR_RESTAURANTS', false);
        });

        Gate::define('RESTAURANT_CUISINE', function ($user){
            return $user->canDo('RESTAURANT_CUISINE', false);
        });

        Gate::define('RESTAURANT_SHOP_PROFILE', function ($user){
            return $user->canDo('RESTAURANT_SHOP_PROFILE', false);
        });

        Gate::define('CUSTOMER_TYPES_RESTAURANTS', function ($user){
            return $user->canDo('CUSTOMER_TYPES_RESTAURANTS', false);
        });

        Gate::define('RESTAURANT_ACCOUNT_TYPE', function ($user){
            return $user->canDo('RESTAURANT_ACCOUNT_TYPE', false);
        });
        Gate::define('TASKS_FOR_ADVERTISERS_COMPANIES', function ($user){
            return $user->canDo('TASKS_FOR_ADVERTISERS_COMPANIES', false);
        });

        Gate::define('TASKS_FOR_RESTAURANT_COMPANIES', function ($user){
            return $user->canDo('TASKS_FOR_RESTAURANT_COMPANIES', false);
        });
        Gate::define('ADD_DISTRICTS', function ($user){
            return $user->canDo('ADD_DISTRICTS', false);
        });
        Gate::define('RESTAURANT_TYPE', function ($user){
            return $user->canDo('RESTAURANT_TYPE', false);
        });
        Gate::define('SHOPS', function ($user){
            return $user->canDo('SHOPS', false);
        });
        Gate::define('APPROVE_USERS', function ($user){
            return $user->canDo('APPROVE_USERS', false);
        });

    }
}
