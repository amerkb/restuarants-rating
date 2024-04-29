<?php

namespace App\Http\Controllers\DashboardAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantRequest;
use App\Interfaces\DashboardAdmin\RestaurantInterface;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    protected $restaurant;

    public function __construct(RestaurantInterface $restaurant)
    {
        $this->restaurant = $restaurant;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->restaurant->getRestaurant();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RestaurantRequest $request)
    {
        return $this->restaurant->storeRestaurant($request->validated());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeRestaurantsByNumber(Request $request)
    {
        return $this->restaurant->storeRestaurantsByNumber($request->number);

    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant)
    {
        return $this->restaurant->showRestaurant($restaurant);

    }

    /**
     * Display the specified resource.
     */
    public function RestaurantByUuid(Restaurant $restaurant)
    {
        return $this->restaurant->showRestaurant($restaurant);
    }

    public function getRestaurantsByAttribute(Request $request)
    {
        return $this->restaurant->getRestaurantsByAttribute($request);
    }

    /*
     * Update the specified resource in storage.
     */
    public function update(RestaurantRequest $request, Restaurant $restaurant)
    {
        return $this->restaurant->updateRestaurant($request->validated(), $restaurant);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        return $this->restaurant->deleteRestaurant($restaurant);

    }
}
