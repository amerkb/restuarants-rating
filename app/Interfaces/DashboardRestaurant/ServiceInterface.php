<?php

namespace App\Interfaces\DashboardRestaurant;

use App\Models\Service;

interface ServiceInterface
{
    public function getServices();

    public function showService(Service $service);

    public function storeService(array $dataService);

    public function updateService(array $dataService, Service $service);

    public function deleteService(Service $service);
}
