<?php

namespace App\Interfaces\DashboardRestaurant;

use App\Models\Addition;

interface AdditionInterface
{
    public function getMeals();

    public function showMeal(Addition $meal);

    public function storeMeal(array $dataMeal);

    public function updateMeal(array $dataMeal, Addition $meal);

    public function deleteMeal(Addition $meal);

    public function avgMeals();
}
