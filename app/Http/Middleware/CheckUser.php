<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUser
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $token = $request->header('Authorization');
        $request->headers->set('auth-token', (string) $token, true);
        $request->headers->set('Authorization', 'Bearer '.$token, true);
        $auth = false;
        foreach ($roles as $role) {
            if (Auth::guard($role)->check()) {
                $auth = true;
            }
        }
        if ($auth == false) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
