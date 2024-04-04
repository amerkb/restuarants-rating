<?php

namespace App\Providers;

use App\Interfaces\DashboardAdmin\RestaurantInterface;
use App\Interfaces\DashboardRestaurant\BackgroundInterface;
use App\Interfaces\DashboardRestaurant\LogoInterface;
use App\Interfaces\DashboardRestaurant\MealInterface;
use App\Interfaces\DashboardRestaurant\RestaurantDetailInterface;
use App\Interfaces\DashboardRestaurant\ServiceInterface;
use App\Interfaces\user\RatingInterface;
use App\Repository\DashboardAdmin\RestaurantRepository;
use App\Repository\DashboardRestaurant\BackgroundRepository;
use App\Repository\DashboardRestaurant\LogoRepository;
use App\Repository\DashboardRestaurant\MealRepository;
use App\Repository\DashboardRestaurant\RestaurantDetailRepository;
use App\Repository\DashboardRestaurant\ServiceRepository;
use App\Repository\user\RatingRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        JsonResource::withoutWrapping();
        $this->app->bind(RestaurantInterface::class, function () {
            return new RestaurantRepository();
        });
        $this->app->bind(MealInterface::class, function () {
            return new MealRepository();
        });
        $this->app->bind(ServiceInterface::class, function () {
            return new ServiceRepository();
        });
        $this->app->bind(LogoInterface::class, function () {
            return new LogoRepository();
        });
        $this->app->bind(BackgroundInterface::class, function () {
            return new BackgroundRepository();
        });
        $this->app->bind(RatingInterface::class, function () {
            return new RatingRepository();
        });
        $this->app->bind(RestaurantDetailInterface::class, function () {
            return new RestaurantDetailRepository();
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
