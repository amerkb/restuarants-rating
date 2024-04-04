<?php

namespace App\Repository\DashboardRestaurant;

use App\Abstract\BaseRepositoryImplementation;
use App\ApiHelper\ApiResponseCodes;
use App\ApiHelper\ApiResponseHelper;
use App\ApiHelper\Result;
use App\Http\Resources\ServiceResource;
use App\Interfaces\DashboardRestaurant\ServiceInterface;
use App\Models\Service;

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
        $services = $this->get();
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
        $service = $this->updateById($service->id, $dataService);
        $service = ServiceResource::make($service);

        return ApiResponseHelper::sendResponse(
            new Result($service, 'Done')
        );
    }

    public function deleteService(Service $service)
    {
        $this->deleteById($service->id);

        return ApiResponseHelper::sendMessageResponse(
            'deleted successfully'
        );
    }
}
