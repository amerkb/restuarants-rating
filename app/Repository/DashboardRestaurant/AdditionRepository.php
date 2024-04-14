<?php

namespace App\Repository\DashboardRestaurant;

use App\Abstract\BaseRepositoryImplementation;
use App\ApiHelper\ApiResponseCodes;
use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Resources\AdditionResource;
use App\Interfaces\DashboardRestaurant\AdditionInterface;
use App\Models\Addition;
use Illuminate\Support\Facades\File;

class AdditionRepository extends BaseRepositoryImplementation implements AdditionInterface
{
    public function model()
    {
        return Addition::class;
    }

    public function getFilterItems($filter)
    {
        // TODO: Implement getFilterItems() method.
    }

    public function getMeals()
    {
        $meals = $this->get();
        $meals = AdditionResource::collection($meals);

        return ApiResponseHelper::sendResponse(
            new Result($meals, 'Done')
        );
    }

    public function showMeal(Addition $meal)
    {
        $meal = AdditionResource::make($meal);

        return ApiResponseHelper::sendResponse(
            new Result($meal, 'Done')
        );
    }

    public function storeMeal(array $dataMeal)
    {
        $meal = $this->create($dataMeal);
        $meal = AdditionResource::make($meal);

        return ApiResponseHelper::sendResponse(
            new Result($meal, 'Done'), ApiResponseCodes::CREATED
        );
    }

    public function updateMeal(array $dataMeal, Addition $meal)
    {
        if ($dataMeal['image']) {
            File::delete(public_path($meal->image));

        }
        $meal = $this->updateById($meal->id, $dataMeal);
        $meal = AdditionResource::make($meal);

        return ApiResponseHelper::sendResponse(
            new Result($meal, 'Done')
        );
    }

    public function deleteMeal(Addition $meal)
    {
        File::delete(public_path($meal->image));
        $this->deleteById($meal->id);

        return ApiResponseHelper::sendMessageResponse(
            'deleted successfully'
        );

    }

    public function avgMeals()
    {
        $this->scopes = 'averageRating';

        return $this->get();
    }
}
