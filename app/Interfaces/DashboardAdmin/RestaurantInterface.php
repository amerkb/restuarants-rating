<?php

namespace App\Interfaces\DashboardAdmin;

use App\Models\Restaurant;

interface RestaurantInterface
{
    public function getRestaurant();

    public function showRestaurant(Restaurant $restaurant);

    public function storeRestaurant(array $dataRestaurant);

    public function storeRestaurantsByNumber(int $number);

    public function updateRestaurant(array $dataRestaurant, Restaurant $restaurant);

    public function deleteRestaurant(Restaurant $restaurant);
}
