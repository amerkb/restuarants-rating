<?php

namespace App\Repository\DashboardRestaurant;

use App\Abstract\BaseRepositoryImplementation;
use App\ApiHelper\ApiResponseCodes;
use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Resources\RestaurantResource;
use App\Interfaces\DashboardRestaurant\RestaurantDetailInterface;
use App\Models\Branch;
use App\Models\RestaurantDetail;
use Illuminate\Support\Facades\Auth;

class RestaurantDetailRepository extends BaseRepositoryImplementation implements RestaurantDetailInterface
{
    public function model()
    {
        return RestaurantDetail::class;
    }

    public function getFilterItems($filter)
    {
        // TODO: Implement getFilterItems() method.
    }

    public function storeDetail(array $dataDetail)
    {
        $data = array_merge(['restaurant_id' => Auth::id()], $dataDetail);
        $this->updateOrCreate(['restaurant_id' => Auth::id()], $data);
        if (isset($dataDetail['branch'])) {
            Branch::updateOrCreate(['restaurant_id' => Auth::id()], ['restaurant_id' => Auth::id(), 'name' => $dataDetail['branch']]);
        }
        $restaurant = RestaurantResource::make(Auth::user());

        return ApiResponseHelper::sendResponse(new Result($restaurant, 'done'), ApiResponseCodes::CREATED);

    }

    public function updateDetail(array $dataDetail)
    {
        $data = array_merge(['restaurant_id' => Auth::id()], $dataDetail);
        $this->updateOrCreate(['restaurant_id' => Auth::id()], $data);
        if (isset($dataDetail['branch'])) {
            Branch::updateOrCreate(['restaurant_id' => Auth::id()], ['restaurant_id' => Auth::id(), 'name' => $dataDetail['branch']]);
        }
        $restaurant = RestaurantResource::make(Auth::user());

        return ApiResponseHelper::sendResponse(new Result($restaurant, 'done'));
    }

    public function changeStatus()
    {
        $restaurant = Auth::user();
        $restaurant->update(['status' => ! $restaurant->status]);

        return ApiResponseHelper::sendMessageResponse('update successfully');
    }
}
