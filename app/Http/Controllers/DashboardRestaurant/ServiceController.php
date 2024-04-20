<?php

namespace App\Http\Controllers\DashboardRestaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Http\Resources\RestaurantResource;
use App\Interfaces\DashboardRestaurant\ServiceInterface;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    protected $service;

    public function __construct(ServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->service->getServices();
    }

    /**
     * Display a listing of the resource.
     */
    public function tableServicesWithoutSub(Request $request)
    {
        return $this->service->tableServices($request);
    }

    public function chartService()
    {
        return $this->service->chartService();
    }

    public function avgService()
    {
        return $this->service->avgService();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequest $request)
    {
        $data = array_merge(['restaurant_id' => Auth::id()], $request->validated());

        return $this->service->storeService($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return $this->service->showService($service);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceRequest $request, Service $service)
    {

        $data = array_merge(['restaurant_id' => Auth::user()->id], $request->validated());

        return $this->service->updateService($data, $service);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        return $this->service->deleteService($service);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function a()
    {
        return RestaurantResource::make(Auth::user());

    }
}
