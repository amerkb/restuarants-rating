<?php

namespace App\Repository\DashboardRestaurant;

use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Resources\TableResource;
use App\Interfaces\DashboardRestaurant\RatingInterface;

class RatingRepository implements RatingInterface
{
    public function getRating()
    {
        $restaurant = auth('restaurant')->user();
        $userService = $restaurant->ratingServices;
        $ratings = $userService->groupby('rating_id');
        $i = 0;
        $children = [];
        $new = [];
        $parent = null;
        foreach ($ratings as $index => $rating) {
            $i++;

            $children = [];
            $parent = null;
            foreach ($rating as $key => $value) {
                $value['idd'] = $i.'_'.$key + 1;
                $children[$key] = $value;
                $parent = $value;

            }
            $k = $i - 1;
            $parent['idd'] = ''.$i.'';
            $new[$k] = $parent;
            $new[$k]['children'] = $children;
        }

        $data = TableResource::collection($new);

        return ApiResponseHelper::sendResponse(new Result($data, 'Done'));

    }
}
