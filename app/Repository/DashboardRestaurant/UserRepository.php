<?php

namespace App\Repository\DashboardRestaurant;

use App\Abstract\BaseRepositoryImplementation;
use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Resources\UserResource;
use App\Interfaces\DashboardRestaurant\UserInterface;
use App\Models\Restaurant;

class UserRepository extends BaseRepositoryImplementation implements UserInterface
{
    public function getUser()
    {
        $this->with('users');
        $restaurant = $this->getById(auth()->id());
        $data = UserResource::collection($restaurant->users);
        foreach ($data as $index => $datum) {
            $datum['id'] = $index + 1;
        }
        $count = count($restaurant->users)??0;

        return ApiResponseHelper::sendResponseWithKey(new Result($data), ['count' => $count, 'status' => boolval($restaurant->infoStatus)]);

    }

    public function model()
    {
        return Restaurant::class;
    }

    public function getFilterItems($filter)
    {
        // TODO: Implement getFilterItems() method.
    }
}
