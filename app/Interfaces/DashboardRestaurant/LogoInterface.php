<?php

namespace App\Interfaces\DashboardRestaurant;

use App\Models\RestaurantDetail;

interface LogoInterface
{
    public function showLogo(RestaurantDetail $restaurantDetail);

    public function storeLogo(array $dataLogo);

    public function updateLogo(array $dataLogo, RestaurantDetail $restaurantDetail);

    public function deleteLogo(RestaurantDetail $restaurantDetail);
}
