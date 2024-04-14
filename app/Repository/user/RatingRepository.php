<?php

namespace App\Repository\user;

use App\Abstract\BaseRepositoryImplementation;
use App\ApiHelper\ApiResponseCodes;
use App\ApiHelper\ApiResponseHelper;
use App\Http\Requests\RatingRequest;
use App\Interfaces\user\RatingInterface;
use App\Models\Rating;
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
                $user = $this->updateOrCreate(['phone' => $request->phone, 'name' => $request->name], $data);
                $user->restaurants()->syncWithoutDetaching($request->restaurant_id);
                $user = $user->id;

            }
            $rating = Rating::create(['restaurant_id' => $request->restaurant_id]);
            if (isset($request->additions)) {
                $additions = [];
                foreach ($request->additions as $index => $addition) {
                    if (isset($addition['rating'])) {
                        $additions[$index] = [
                            'user_id' => $user,
                            'addition_id' => $addition['id'],
                            'rating' => $addition['rating'],
                            'created_at' => now(),
                            'rating_id' => $rating->id,

                        ];
                    }
                }
                DB::table('users_additions')->insert($additions);
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
                            'rating_id' => $rating->id,

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
