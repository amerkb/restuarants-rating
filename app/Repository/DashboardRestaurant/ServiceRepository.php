<?php

namespace App\Repository\DashboardRestaurant;

use App\Abstract\BaseRepositoryImplementation;
use App\ApiHelper\ApiResponseCodes;
use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\TableResource;
use App\Interfaces\DashboardRestaurant\ServiceInterface;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceRepository extends BaseRepositoryImplementation implements ServiceInterface
{
    public function model()
    {
        return Service::class;
    }

    public function getFilterItems($filter)
    {
        // TODO: Implement getFilterItems() method.
    }

    public function getServices()
    {
        $services = $this->where('restaurant_id', Auth::id())->get();
        foreach ($services as $index => $service) {
            $service['idd'] = $index + 1;
        }
        $services = ServiceResource::collection($services);

        return ApiResponseHelper::sendResponse(
            new Result($services, 'Done')
        );
    }

    public function showService(Service $service)
    {

        $service = ServiceResource::make($service);

        return ApiResponseHelper::sendResponse(
            new Result($service, 'Done')
        );
    }

    public function storeService(array $dataService)
    {

        $service = $this->create($dataService);
        $service = ServiceResource::make($service);

        return ApiResponseHelper::sendResponse(
            new Result($service, 'Done'), ApiResponseCodes::CREATED
        );
    }

    public function updateService(array $dataService, Service $service)
    {
        $result = $this->checkServiceOwnership($service);
        if ($result) {
            return $result;
        }

        $service = $this->updateById($service->id, $dataService);

        $service = ServiceResource::make($service);

        return ApiResponseHelper::sendResponse(
            new Result($service, 'Done')
        );
    }

    public function deleteService(Service $service)
    {
        $result = $this->checkServiceOwnership($service);
        if ($result) {
            return $result;
        }
        $this->deleteById($service->id);

        return ApiResponseHelper::sendMessageResponse(
            'deleted successfully'
        );
    }

    public function tableServices(Request $request)
    {
        $restaurant = auth()->user();
        $userService = null;
        if ($request->startDate && $request->endDate) {
            $userService = $restaurant->ratingServices()
                ->whereBetween('users_services.created_at', [$request->startDate.' 00:00:00', $request->endDate.' 23:59:59'])
                ->with(['service', 'rate', 'user'])->get();
        } else {
            $userService = $restaurant->ratingServices()
                ->with(['service', 'rate', 'user'])->get();
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

    public function avgService()
    {
        $restaurant = Auth::user();
        $avg = $restaurant->avgService();

        return ApiResponseHelper::sendResponseOnlyKey(['avg' => floatval($avg)]);
    }

    public function chartService()
    {
        $services = $this->where('restaurant_id', Auth::id())->get();
        $services = ServiceResource::collection($services);

        return ApiResponseHelper::sendResponse(
            new Result($services, 'Done')
        );
    }

    public function checkServiceOwnership($service)
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
