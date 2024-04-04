<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatingRequest;
use App\Interfaces\user\RatingInterface;

class RatingController extends Controller
{
    protected $rating;

    public function __construct(RatingInterface $rating)
    {
        $this->rating = $rating;
    }

    public function store(RatingRequest $request)
    {
        return $this->rating->storeRating($request);
    }
}
