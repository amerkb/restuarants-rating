<?php

namespace App\Http\Controllers\DashboardRestaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\MealRequest;
use App\Interfaces\DashboardRestaurant\MealInterface;
use App\Models\Meal;
use Illuminate\Support\Facades\Auth;

class MealController extends Controller
{
    protected $meal;

    public function __construct(MealInterface $meal)
    {
        $this->meal = $meal;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->meal->getMeals();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MealRequest $request)
    {
        $data = array_merge(['restaurant_id' => Auth::guard('restaurant')->id()], $request->validated());

        return $this->meal->storeMeal($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Meal $meal)
    {
        return $this->meal->showMeal($meal);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MealRequest $request, Meal $meal)
    {
        $data = array_merge(['restaurant_id' => Auth::guard('restaurant')->id()], $request->validated());

        return $this->meal->updateMeal($data, $meal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meal $meal)
    {

        return $this->meal->deleteMeal($meal);

    }
}
