<?php

namespace App\Interfaces\DashboardRestaurant;

use App\Models\Addition;
use Illuminate\Http\Request;

interface AdditionInterface
{
    public function getMeals();

    public function tableAddition(Request $request);

    public function avgAddition();

    public function chartAddition();

    public function showMeal(Addition $meal);

    public function storeMeal(array $dataMeal);

    public function updateMeal(array $dataAddition, Addition $addition);

    public function deleteMeal(Addition $meal);
}
