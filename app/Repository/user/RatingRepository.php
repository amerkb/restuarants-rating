<?php

namespace App\Repository\user;

use App\Abstract\BaseRepositoryImplementation;
use App\ApiHelper\ApiResponseCodes;
use App\ApiHelper\ApiResponseHelper;
use App\Http\Requests\RatingRequest;
use App\Interfaces\user\RatingInterface;
use App\Models\Rating;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RatingRepository extends BaseRepositoryImplementation implements RatingInterface
{
    public function storeRating(RatingRequest $request)
    {
        try {
            DB::beginTransaction();
            if (! isset($request->additions) && ! isset($request->services)) {
                return ApiResponseHelper::sendMessageResponse(
                    'send data to rating', 422, false);
            }

            $user = null;
            $restaurant = Restaurant::where('uuid', $request->restaurant_uuid)->first();
            if (! $restaurant) {
                return ApiResponseHelper::sendMessageResponse(
                    'send uuid right', 422, false);
            }

            if ($request->phone && $request->name) {
                $data = ['phone' => $request->phone, 'name' => $request->name];
                $user = $this->updateOrCreate(['phone' => $request->phone, 'name' => $request->name], $data);
                $user->restaurants()->syncWithoutDetaching($restaurant->id);
                $user = $user->id;

            }
            $rating = Rating::create(['restaurant_id' => $restaurant->id, 'note' => $request->note]);
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

            DB::commit();

            return ApiResponseHelper::sendMessageResponse(
                'add successfully');
        } catch (\Exception $e) {
            DB::rollback();

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
