<?php

namespace App\Http\Controllers\DashboardRestaurant;

use App\Http\Controllers\Controller;
use App\Interfaces\DashboardRestaurant\UserInterface;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user->getUser();
    }
}
