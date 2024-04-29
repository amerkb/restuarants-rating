<?php

namespace App\Interfaces\DashboardAdmin;

use App\Models\Restaurant;
use Illuminate\Http\Request;

interface RestaurantInterface
{
    public function getRestaurant();

    public function showRestaurant(Restaurant $restaurant);

    public function getRestaurantsByAttribute(Request $request);

    public function storeRestaurant(array $dataRestaurant);

    public function storeRestaurantsByNumber(int $number);

    public function updateRestaurant(array $dataRestaurant, Restaurant $restaurant);

    public function deleteRestaurant(Restaurant $restaurant);
}
