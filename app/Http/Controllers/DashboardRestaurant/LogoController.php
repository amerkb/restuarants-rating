<?php

namespace App\Http\Controllers\DashboardRestaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Interfaces\DashboardRestaurant\LogoInterface;
use App\Models\RestaurantDetail;
use Illuminate\Support\Facades\Auth;

class LogoController extends Controller
{
    protected $logo;

    public function __construct(LogoInterface $logo)
    {
        $this->logo = $logo;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ImageRequest $request)
    {
        $data = array_merge(['restaurant_id' => Auth::guard('restaurant')->id(), 'logo' => $request->file('image')]);

        return $this->logo->storeLogo($data);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $restaurantDetail = RestaurantDetail::findOrFail(Auth::guard('restaurant')->id());

        return $this->logo->showLogo($restaurantDetail);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ImageRequest $request)
    {
        $data = array_merge(['restaurant_id' => Auth::guard('restaurant')->id(), 'logo' => $request->file('image')]);
        $restaurantDetail = RestaurantDetail::findOrFail(Auth::guard('restaurant')->id());

        return $this->logo->updateLogo($data, $restaurantDetail);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        $restaurantDetail = RestaurantDetail::findOrFail(Auth::guard('restaurant')->id());

        return $this->logo->deleteLogo($restaurantDetail);

    }
}
