<?php

namespace App\Http\Controllers\DashboardRestaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Interfaces\DashboardRestaurant\BackgroundInterface;
use App\Models\RestaurantDetail;
use Illuminate\Support\Facades\Auth;

class BackgroundController extends Controller
{
    protected $background;

    public function __construct(BackgroundInterface $background)
    {
        $this->background = $background;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ImageRequest $request)
    {
        $data = array_merge(['restaurant_id' => Auth::id(), 'background' => $request->file('image')]);

        return $this->background->storeBackground($data);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $restaurantDetail = RestaurantDetail::findOrFail(Auth::id());

        return $this->background->showBackground($restaurantDetail);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ImageRequest $request)
    {
        $data = array_merge(['restaurant_id' => Auth::id(), 'background' => $request->file('image')]);
        $restaurantDetail = RestaurantDetail::findOrFail(Auth::id());

        return $this->background->updateBackground($data, $restaurantDetail);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        $restaurantDetail = RestaurantDetail::findOrFail(Auth::id());

        return $this->background->deleteBackground($restaurantDetail);
    }
}
