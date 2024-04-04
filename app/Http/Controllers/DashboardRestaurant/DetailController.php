<?php

namespace App\Http\Controllers\DashboardRestaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantDetailRequest;
use App\Interfaces\DashboardRestaurant\RestaurantDetailInterface;

class DetailController extends Controller
{
    protected $detail;

    public function __construct(RestaurantDetailInterface $restaurantDetail)
    {
        $this->detail = $restaurantDetail;
    }

    public function store(RestaurantDetailRequest $request)
    {
        return $this->detail->storeDetail($request->validated());
    }

    public function update(RestaurantDetailRequest $request)
    {
        return $this->detail->updateDetail($request->validated());

    }
}