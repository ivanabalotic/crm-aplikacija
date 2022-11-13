<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Staff;

class IsManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $token = $request->header('token');
        $user = Staff::where('api_token', $token)->first();

        if ($user->role !== 'manager') {
            return response()->json(['message' => 'Not authorized'], 401);
        }

        return $next($request);
    }
}
