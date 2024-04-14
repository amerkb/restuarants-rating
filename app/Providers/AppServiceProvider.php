<?php

namespace App\Providers;

use App\Interfaces\DashboardAdmin\RestaurantInterface;
use App\Interfaces\DashboardRestaurant\AdditionInterface;
use App\Interfaces\DashboardRestaurant\BackgroundInterface;
use App\Interfaces\DashboardRestaurant\LogoInterface;
use App\Interfaces\DashboardRestaurant\RatingInterface as IRR;
use App\Interfaces\DashboardRestaurant\RestaurantDetailInterface;
use App\Interfaces\DashboardRestaurant\ServiceInterface;
use App\Interfaces\DashboardRestaurant\UserInterface;
use App\Interfaces\user\RatingInterface;
use App\Repository\DashboardAdmin\RestaurantRepository;
use App\Repository\DashboardRestaurant\AdditionRepository;
use App\Repository\DashboardRestaurant\BackgroundRepository;
use App\Repository\DashboardRestaurant\LogoRepository;
use App\Repository\DashboardRestaurant\RatingRepository as RRR;
use App\Repository\DashboardRestaurant\RestaurantDetailRepository;
use App\Repository\DashboardRestaurant\ServiceRepository;
use App\Repository\DashboardRestaurant\UserRepository;
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
        $this->app->bind(AdditionInterface::class, function () {
            return new AdditionRepository();
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
        $this->app->bind(IRR::class, function () {
            return new RRR();
        });
        $this->app->bind(UserInterface::class, function () {
            return new UserRepository();
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
