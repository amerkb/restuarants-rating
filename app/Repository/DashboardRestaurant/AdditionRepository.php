<?php

namespace App\Repository\DashboardRestaurant;

use App\Abstract\BaseRepositoryImplementation;
use App\ApiHelper\ApiResponseCodes;
use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Resources\AdditionResource;
use App\Http\Resources\TableResource;
use App\Interfaces\DashboardRestaurant\AdditionInterface;
use App\Models\Addition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        foreach ($meals as $index => $meal) {
            $meal['idd'] = $index + 1;
        }
        $meals = AdditionResource::collection($meals);

        return ApiResponseHelper::sendResponseWithKey(
            new Result($meals, 'Done'), ['additionalStatus' => boolval(Auth::user()->additionalStatus)]
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

    public function updateMeal(array $dataAddition, Addition $addition)
    {
        $addition = $this->updateById($addition->id, $dataAddition);
        $addition = AdditionResource::make($addition);

        return ApiResponseHelper::sendResponse(
            new Result($addition, 'Done')
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

    public function tableAddition(Request $request)
    {
        $restaurant = auth()->user();
        $userAdditions = null;
        if ($request->startDate && $request->endDate) {
            $userAdditions = $restaurant->ratingAdditions()
                ->whereBetween('users_additions.created_at', [$request->startDate.' 00:00:00', $request->endDate.' 23:59:59'])
                ->with(['addition', 'rate', 'user'])->get();
        } else {
            $userAdditions = $restaurant->ratingAdditions()
                ->with(['addition', 'rate', 'user'])->get();
        }
        $ratings = $userAdditions->groupby('rating_id');

        $i = 0;
        $children = [];
        $new = [];
        $parent = null;

        foreach ($ratings as $index => $rating) {
            $i++;
            $children = [];
            $parent = null;
            $rate = 0;

            foreach ($rating as $key => $value) {
                $value['idd'] = $i.'_'.$key + 1;
                $children[$key] = $value;
                $rate = $rate + $value->rating;

            }
            $k = $i - 1;
            $parent['idd'] = ''.$i.'';
            $parent['name'] = 'overall';
            $parent['rating'] = $rate / count($rating);
            $parent['date'] = $rating[0]->created_at->toDateTimeString();
            $parent['userName'] = $rating[0]->user->name ?? null;
            $parent['userPhone'] = $rating[0]->user->phone ?? null;
            $parent['note'] = $rating[0]->rate->note ?? null;

            $new[$k] = $parent;
            $new[$k]['children'] = $children;
        }
        $data = TableResource::collection($new);

        return ApiResponseHelper::sendResponse(new Result($data, 'Done'));
    }

    public function avgAddition()
    {
        $restaurant = Auth::user();
        $avg = $restaurant->avgAddition();

        return ApiResponseHelper::sendResponseOnlyKey(['avg' => floatval($avg)]);
    }

    public function chartAddition()
    {
        $additions = $this->all();

        $additions = AdditionResource::collection($additions);

        return ApiResponseHelper::sendResponse(
            new Result($additions, 'Done')
        );
    }

    public function changeStatusAdditional()
    {
        $restaurant = Auth::user();
        $restaurant->update(['additionalStatus' => ! $restaurant->additionalStatus]);

        return ApiResponseHelper::sendMessageResponse('update successfully');
    }
}
