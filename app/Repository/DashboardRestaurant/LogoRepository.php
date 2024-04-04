<?php

namespace App\Repository\DashboardRestaurant;

use App\Abstract\BaseRepositoryImplementation;
use App\ApiHelper\ApiResponseCodes;
use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Resources\RestaurantResource;
use App\Interfaces\DashboardRestaurant\LogoInterface;
use App\Models\RestaurantDetail;
use Illuminate\Support\Facades\File;

class LogoRepository extends BaseRepositoryImplementation implements LogoInterface
{
    public function model()
    {
        return RestaurantDetail::class;
    }

    public function getFilterItems($filter)
    {
        // TODO: Implement getFilterItems() method.
    }

    public function showLogo(RestaurantDetail $restaurantDetail)
    {
        return ApiResponseHelper::sendResponse(
            new Result(['logo' => url($restaurantDetail->logo)], 'Done')
        );
    }

    public function storeLogo(array $dataLogo)
    {
        $restaurantDetail = $this->updateOrCreate(['restaurant_id' => $dataLogo['restaurant_id']], $dataLogo);
        $restaurant = RestaurantResource::make($restaurantDetail);

        return ApiResponseHelper::sendResponse(
            new Result($restaurant, 'Done'), ApiResponseCodes::CREATED
        );
    }

    public function updateLogo(array $dataLogo, RestaurantDetail $restaurantDetail)
    {
        if ($dataLogo['logo']) {
            File::delete(public_path($restaurantDetail->logo));
        }
        $restaurantDetail = $this->updateOrCreate(['restaurant_id' => $dataLogo['restaurant_id']], $dataLogo);
        $restaurant = RestaurantResource::make($restaurantDetail);

        return ApiResponseHelper::sendResponse(
            new Result($restaurant, 'Done')
        );
    }

    public function deleteLogo(RestaurantDetail $restaurantDetail)
    {
        File::delete(public_path($restaurantDetail->logo));
        RestaurantDetail::where('restaurant_id', $restaurantDetail->restaurant_id)->update(['logo' => null]);

        return ApiResponseHelper::sendMessageResponse(
            'deleted successfully');
    }
}
