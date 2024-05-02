<?php

namespace App\Interfaces\DashboardRestaurant;

use App\Models\Service;
use Illuminate\Http\Request;

interface ServiceInterface
{
    public function getServices();

    public function getServicesSub();

    public function tableServices(Request $request);

    public function tableServicesSubs(Request $request);

    public function avgService();

    public function changeParent(array $data);

    public function chartService();

    public function chartServiceSub();

    public function showService(Service $service);

    public function storeService(array $dataService);

    public function updateService(array $dataService, Service $service);

    public function deleteService(Service $service);
}
