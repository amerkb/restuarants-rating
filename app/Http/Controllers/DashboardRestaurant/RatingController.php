<?php

namespace App\Http\Controllers\DashboardRestaurant;

use App\Http\Controllers\Controller;
use App\Interfaces\DashboardRestaurant\RatingInterface;

class RatingController extends Controller
{
    protected $rating;

    public function __construct(RatingInterface $rating)
    {
        $this->rating = $rating;
    }

    public function getData()
    {
        return $this->rating->getRating();
    }
}
