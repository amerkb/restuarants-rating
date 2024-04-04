<?php

namespace App\Repository\user;

use App\Abstract\BaseRepositoryImplementation;
use App\ApiHelper\ApiResponseCodes;
use App\ApiHelper\ApiResponseHelper;
use App\Http\Requests\RatingRequest;
use App\Interfaces\user\RatingInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RatingRepository extends BaseRepositoryImplementation implements RatingInterface
{
    public function storeRating(RatingRequest $request)
    {
        try {
            $user = null;
            if ($request->phone && $request->name) {
                $data = ['phone' => $request->phone, 'name' => $request->name];
                $user = $this->create($data);
                $user = $user->id;
            }

            if (isset($request->meals)) {
                $meals = [];
                foreach ($request->meals as $index => $meal) {
                    if (isset($meal['rating'])) {
                        $meals[$index] = [
                            'user_id' => $user,
                            'meal_id' => $meal['id'],
                            'rating' => $meal['rating'],
                            'created_at' => now(),
                        ];
                    }
                }
                DB::table('users_meals')->insert($meals);
            }
            if (isset($request->services)) {
                $services = [];
                foreach ($request->services as $index => $service) {
                    if (isset($service['rating'])) {
                        $services[$index] = [
                            'user_id' => $user,
                            'service_id' => $service['id'],
                            'rating' => $service['rating'],
                            'created_at' => now(),
                        ];
                    }
                }
                DB::table('users_services')->insert($services);
            }

            return ApiResponseHelper::sendMessageResponse(
                'add successfully');
        } catch (\Exception $e) {
            return ApiResponseHelper::sendMessageResponse(
                $e->getMessage(), ApiResponseCodes::BAD_REQUEST, false);
        }
    }

    public function model()
    {
        return User::class;
    }

    public function getFilterItems($filter)
    {

    }
}
