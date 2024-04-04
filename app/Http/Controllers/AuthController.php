<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth('admin')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token, auth('admin')->user());
    }

    public function loginRestaurant(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $restaurant = Restaurant::where('name', $request->name)->first();

        if (! $restaurant || md5($request->password) != $restaurant->password) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $token = JWTAuth::fromUser($restaurant);

        return $this->createNewToken($token, $restaurant);

    }

    protected function createNewToken($token, $user)
    {
        return response()->json([
            'access_token' => $token,
            'user' => $user,
        ]);
    }
}
