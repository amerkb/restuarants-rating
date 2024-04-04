<?php

namespace App\Interfaces\DashboardRestaurant;

use App\Models\Meal;

interface MealInterface
{
    public function getMeals();

    public function showMeal(Meal $meal);

    public function storeMeal(array $dataMeal);

    public function updateMeal(array $dataMeal, Meal $meal);

    public function deleteMeal(Meal $meal);
}
