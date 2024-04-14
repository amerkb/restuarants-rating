<?php

namespace App\Http\Controllers\DashboardRestaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdditionRequest;
use App\Interfaces\DashboardRestaurant\AdditionInterface;
use App\Models\Addition;
use Illuminate\Support\Facades\Auth;

class AdditionController extends Controller
{
    protected $meal;

    public function __construct(AdditionInterface $meal)
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
    public function store(AdditionRequest $request)
    {
        $data = array_merge(['restaurant_id' => Auth::guard('restaurant')->id()], $request->validated());

        return $this->meal->storeMeal($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Addition $meal)
    {
        return $this->meal->showMeal($meal);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdditionRequest $request, Addition $meal)
    {
        $data = array_merge(['restaurant_id' => Auth::guard('restaurant')->id()], $request->validated());

        return $this->meal->updateMeal($data, $meal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Addition $meal)
    {

        return $this->meal->deleteMeal($meal);

    }

    /**
     * average
     */

}
