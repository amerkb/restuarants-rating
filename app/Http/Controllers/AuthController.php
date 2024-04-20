<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthResource;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $admin = Auth::guard('admin')->user();
            $token = $admin->createToken('MyApp', ['admin'])->plainTextToken;

            return $this->createNewToken($token, $admin);
        }

        return response()->json(['error' => 'Unauthorized'], 401);

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
        $token = $restaurant->createToken('MyApp', ['restaurant'])->plainTextToken;

        return $this->createNewToken($token, $restaurant);

    }

    protected function createNewToken($token, $user)
    {
        return response()->json([
            'access_token' => $token,
            'user' => AuthResource::make($user),
        ]);
    }
}
