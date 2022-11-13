<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request) {
        
        $token = new Token;
        $token->setToken($request->header('token'));
        if($token->checkToken())
            return City::all();
        return response()->json(['message' => 'Not logged in'], 401);  
    }

    public function show(City $city, Request $request) {
        $token = new Token;
        $token->setToken($request->header('token'));
        if($token->checkToken())
            return response()->json($city, 200);
        return response()->json(['message' => 'Not logged in'], 401);  
    }

    public function store(Request $request) {

        $token = new Token;
        $token->setToken($request->header('token'));
        if($token->checkToken()) {
            $city = City::create($request->all());

            return response()->json($city, 201);
        } 
        return response()->json(['message'=>'Not logged in'], 401);
    }

    public function update(Request $request, City $city)
    {

        $token = new Token;
        $token->setToken($request->header('token'));
        if ($token->checkToken()) {
            $city->update($request->all());

            return response()->json($city, 200);
        }
        return response()->json(['message' => 'Not logged in'], 401);
    }

    public function delete(Request $request, City $city)
    {
        $token = new Token;
        $token->setToken($request->header('token'));
        if ($token->checkToken()) {
            $city->delete();

            return response()->json(null, 204);
        }
        return response()->json(['message' => 'Not logged in'], 401);
    }
}
