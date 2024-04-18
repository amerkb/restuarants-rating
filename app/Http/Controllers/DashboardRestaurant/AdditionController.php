<?php

namespace App\Http\Controllers\DashboardRestaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdditionRequest;
use App\Interfaces\DashboardRestaurant\AdditionInterface;
use App\Models\Addition;
use Illuminate\Http\Request;
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

    public function tableAddition(Request $request)
    {
        return $this->meal->tableAddition($request);
    }

    public function chartAddition()
    {
        return $this->meal->chartAddition();
    }

    public function avgAddition()
    {
        return $this->meal->avgAddition();
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
    public function show(Addition $addition)
    {
        return $this->meal->showMeal($addition);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdditionRequest $request, Addition $addition)
    {
        $data = array_merge(['restaurant_id' => Auth::guard('restaurant')->id()], $request->validated());

        return $this->meal->updateMeal($data, $addition);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Addition $addition)
    {

        return $this->meal->deleteMeal($addition);

    }

    /**
     * average
     */
}
