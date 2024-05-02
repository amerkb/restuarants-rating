<?php

namespace App\Repository\DashboardRestaurant;

use App\Abstract\BaseRepositoryImplementation;
use App\ApiHelper\ApiResponseCodes;
use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Resources\AdditionResource;
use App\Http\Resources\ChartServiceResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\TableResource;
use App\Interfaces\DashboardRestaurant\AdditionInterface;
use App\Models\Addition;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdditionRepository extends BaseRepositoryImplementation implements AdditionInterface
{
    public function model()
    {
        return Service::class;
    }

    public function getFilterItems($filter)
    {
        // TODO: Implement getFilterItems() method.
    }

    public function getMeals()
    {
        $services = Service::where('restaurant_id', Auth::id())->whereNotNull('parent_id')->get();
        foreach ($services as $index => $service) {
            $service['idd'] = $index + 1;
        }
        $services = AdditionResource::collection($services);

        return ApiResponseHelper::sendResponseWithKey(
            new Result($services, 'Done'),['additionalStatus' => boolval(Auth::user()->additionalStatus)]
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

        $dataService['parent_id'] = Auth::user()->parentService;
        $dataService['restaurant_id'] = Auth::id();
        $dataService['statement'] =$dataMeal['name'];
        $dataService['active'] =$dataMeal['active'];
        $service = $this->create($dataService);
        $service = AdditionResource::make($service);
        return ApiResponseHelper::sendResponse(
            new Result($service, 'Done'), ApiResponseCodes::CREATED
        );
    }

    public function updateMeal(array $dataAddition, Service $service)
    {
        $dataAddition['statement']=$dataAddition['name'];
        $restaurant = Auth::user();
        $result = $this->checkAdditionOwnership($service);
        if ($result) {
            return $result;
        }
        $addition = $this->updateById($service->id, $dataAddition);
        $addition = AdditionResource::make($addition);

        return ApiResponseHelper::sendResponse(
            new Result($addition, 'Done')
        );
    }

    public function deleteMeal(Service $service)
    {
        $result = $this->checkAdditionOwnership($service);
        if ($result) {
            return $result;
        }
        $this->deleteById($service->id);

        return ApiResponseHelper::sendMessageResponse(
            'deleted successfully'
        );

    }

    public function tableAddition(Request $request)
    {
        $restaurant = auth()->user();
        $userService = null;
        if ($request->startDate && $request->endDate) {
            $userService = $restaurant->ratingServices()
                ->whereBetween('users_services.created_at', [$request->startDate.' 00:00:00', $request->endDate.' 23:59:59'])
                ->with(['service', 'rate', 'user'])
                ->whereHas('service', function ($query) {
                    $query->whereNotNull('parent_id');
                })->get();
        } else {
            $userService = $restaurant->ratingServices()
                ->with(['service', 'rate', 'user'])
                ->whereHas('service', function ($query) {
                    $query->whereNotNull('parent_id');
                })->get();
        }
        $ratings = $userService->groupby('rating_id');

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
        if ($request->order == 0) {
            usort($new, function ($a, $b) {
                return $a['rating'] - $b['rating'];
            });
        } elseif ($request->order == 1) {
            usort($new, function ($a, $b) {
                return $b['rating'] - $a['rating'];
            });
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
        $services = Service::where('restaurant_id', Auth::id())->whereNotNull('parent_id')->get();

        $services = ChartServiceResource::collection($services);

        return ApiResponseHelper::sendResponse(
            new Result($services, 'Done')
        );
    }

    public function changeStatusAdditional()
    {
        $restaurant = Auth::user();
        $restaurant->update(['additionalStatus' => ! $restaurant->additionalStatus]);

        return ApiResponseHelper::sendMessageResponse('update successfully');
    }

    public function checkAdditionOwnership($service)
    {
        $restaurant = Auth::user();
        if (! $restaurant->services->contains('id', $service->id)) {
            return ApiResponseHelper::sendMessageResponse(
                'You cannot delete this service',
                403,
                false
            );
        }
    }
}
