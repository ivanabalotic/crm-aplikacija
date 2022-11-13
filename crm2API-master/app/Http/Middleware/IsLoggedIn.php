<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\Token;

class IsLoggedIn
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
        if($request->header('token') === null){
            return response()->json(['message'=>'Not logged in'], 401);
        }

        $token = new Token;
        $token->setToken($request->header('token'));

        if($token->checkToken()) {
            return $next($request);
        } 

        return response()->json(['message'=>'Not valid token'], 401);
    }
}
