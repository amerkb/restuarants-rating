<?php

namespace App\Interfaces\user;

use App\Http\Requests\RatingRequest;

interface RatingInterface
{
    public function storeRating(RatingRequest $request);
}
