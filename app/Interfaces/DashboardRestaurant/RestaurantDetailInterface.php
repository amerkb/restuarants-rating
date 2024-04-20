<?php

namespace App\Interfaces\DashboardRestaurant;

interface RestaurantDetailInterface
{
    public function storeDetail(array $dataDetail);

    public function updateDetail(array $dataDetail);

    public function showDetail();

    public function changeStatus();

    public function changeStatusMessage();
}
