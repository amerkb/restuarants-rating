<?php

namespace App\Repository\DashboardRestaurant;

use App\Abstract\BaseRepositoryImplementation;
use App\ApiHelper\ApiResponseCodes;
use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Resources\MealResource;
use App\Interfaces\DashboardRestaurant\MealInterface;
use App\Models\Meal;
use Illuminate\Support\Facades\File;

class MealRepository extends BaseRepositoryImplementation implements MealInterface
{
    public function model()
    {
        return Meal::class;
    }

    public function getFilterItems($filter)
    {
        // TODO: Implement getFilterItems() method.
    }

    public function getMeals()
    {
        $meals = $this->get();
        $meals = MealResource::collection($meals);

        return ApiResponseHelper::sendResponse(
            new Result($meals, 'Done')
        );
    }

    public function showMeal(Meal $meal)
    {
        $meal = MealResource::make($meal);

        return ApiResponseHelper::sendResponse(
            new Result($meal, 'Done')
        );
    }

    public function storeMeal(array $dataMeal)
    {
        $meal = $this->create($dataMeal);
        $meal = MealResource::make($meal);

        return ApiResponseHelper::sendResponse(
            new Result($meal, 'Done'), ApiResponseCodes::CREATED
        );
    }

    public function updateMeal(array $dataMeal, Meal $meal)
    {
        if ($dataMeal['image']) {
            File::delete(public_path($meal->image));

        }
        $meal = $this->updateById($meal->id, $dataMeal);
        $meal = MealResource::make($meal);

        return ApiResponseHelper::sendResponse(
            new Result($meal, 'Done')
        );
    }

    public function deleteMeal(Meal $meal)
    {
        File::delete(public_path($meal->image));
        $this->deleteById($meal->id);

        return ApiResponseHelper::sendMessageResponse(
            'deleted successfully'
        );

    }
}
