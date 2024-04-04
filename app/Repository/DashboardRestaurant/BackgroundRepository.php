<?php

namespace App\Repository\DashboardRestaurant;

use App\Abstract\BaseRepositoryImplementation;
use App\ApiHelper\ApiResponseCodes;
use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Resources\RestaurantResource;
use App\Interfaces\DashboardRestaurant\BackgroundInterface;
use App\Models\RestaurantDetail;
use Illuminate\Support\Facades\File;

class BackgroundRepository extends BaseRepositoryImplementation implements BackgroundInterface
{
    public function showBackground(RestaurantDetail $restaurantDetail)
    {
        return ApiResponseHelper::sendResponse(
            new Result(['background' => url($restaurantDetail->background)], 'Done')
        );
    }

    public function storeBackground(array $dataBackground)
    {
        $restaurantDetail = $this->updateOrCreate(['restaurant_id' => $dataBackground['restaurant_id']], $dataBackground);
        $restaurant = RestaurantResource::make($restaurantDetail);

        return ApiResponseHelper::sendResponse(
            new Result($restaurant, 'Done'), ApiResponseCodes::CREATED
        );
    }

    public function updateBackground(array $dataBackground, RestaurantDetail $restaurantDetail)
    {
        if ($dataBackground['background']) {
            File::delete(public_path($restaurantDetail->background));
        }
        $restaurantDetail = $this->updateOrCreate(['restaurant_id' => $dataBackground['restaurant_id']], $dataBackground);
        $restaurant = RestaurantResource::make($restaurantDetail);

        return ApiResponseHelper::sendResponse(
            new Result($restaurant, 'Done')
        );
    }

    public function deleteBackground(RestaurantDetail $restaurantDetail)
    {
        File::delete(public_path($restaurantDetail->background));
        RestaurantDetail::where('restaurant_id', $restaurantDetail->restaurant_id)->update(['background' => null]);

        return ApiResponseHelper::sendMessageResponse(
            'deleted successfully');
    }

    public function model()
    {
        return RestaurantDetail::class;
    }

    public function getFilterItems($filter)
    {
        // TODO: Implement getFilterItems() method.
    }
}
