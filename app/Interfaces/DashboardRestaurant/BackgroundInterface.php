<?php

namespace App\Interfaces\DashboardRestaurant;

use App\Models\RestaurantDetail;

interface BackgroundInterface
{
    public function showBackground(RestaurantDetail $restaurantDetail);

    public function storeBackground(array $dataBackground);

    public function updateBackground(array $dataBackground, RestaurantDetail $restaurantDetail);

    public function deleteBackground(RestaurantDetail $restaurantDetail);
}
