<?php

namespace App\Providers;

use App\Contracts\AdvertiserCompanyInterface;
use App\Contracts\ContactsInterface;
use App\Contracts\CountriesInterface;
use App\Contracts\DistrictsInterface;
use App\Contracts\PermissionsInterface;
use App\Contracts\RestaurantShopProfileInterface;
use App\Contracts\RolesInterface;
use App\Contracts\ShopInterface;
use App\Repositories\AdvertiserCompanyRepository;
use App\Repositories\ContactsRepository;
use App\Repositories\CountriesRepository;
use App\Repositories\DistrictsRepository;
use App\Repositories\PermissionsRepository;
use App\Repositories\RestaurantShopProfileRepository;
use App\Repositories\RoleRepository;
use App\Repositories\ShopRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            AdvertiserCompanyInterface::class,
            AdvertiserCompanyRepository::class
        );

        $this->app->bind(
            CountriesInterface::class,
            CountriesRepository::class
        );

        $this->app->bind(
            PermissionsInterface::class,
            PermissionsRepository::class
        );

        $this->app->bind(
            'App\Contracts\RoleContract',
            'App\Repositories\RoleRepository'
        );

        $this->app->bind(
            'App\Contracts\UserContract',
            'App\Repositories\UserRepository'
        );

        $this->app->bind(
            'App\Contracts\CustomerTypeContract',
            'App\Repositories\CustomerTypeRepository'
        );

        $this->app->bind(
            'App\Contracts\RestAccountTypeContract',
            'App\Repositories\RestAccountTypeRepository'
        );

        $this->app->bind(
            'App\Contracts\AdvertiserCompanyContract',
            'App\Repositories\AdvertiserCompanyRepository'
        );

        $this->app->bind(
            ContactsInterface::class,
            ContactsRepository::class
        );

        $this->app->bind(
            CountriesInterface::class,
            CountriesRepository::class
        );

        $this->app->bind(
            RestaurantShopProfileInterface::class,
            RestaurantShopProfileRepository::class
        );

        $this->app->bind(
            ShopInterface::class,
            ShopRepository::class
        );

        $this->app->bind(
            DistrictsInterface::class,
            DistrictsRepository::class
        );
    }
}
