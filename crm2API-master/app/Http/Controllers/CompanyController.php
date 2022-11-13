<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CompanyController extends Controller
{
    public function index(Request $request) {
        $token = new Token;
        $token->setToken($request->header('token'));
        if($token->checkToken()) {
            return Company::all();
        } 
        return response()->json(['message'=>'Not logged in'],401);

    }

    public function indexJoin(Request $request) {

        $token = new Token;
        $token->setToken($request->header('token'));
        if($token->checkToken()) {
            $companies = DB::table('companies')
            ->join('staff','companies.staff_id','=', 'staff.id')
            ->join('cities','companies.city_id', 'cities.id')
            ->select('companies.id', 'company','address',
                'address2','website_url','city_id','staff_id as company_staff_id' ,
                'staff.name as company_added_by', 'cities.city as company_city')
                ->get();
            return $companies;
        } 
        return response()->json(['message'=>'Not logged in'],401);
    }

    public function show(Company $company, Request $request) {
        
        $token = new Token;
        $token->setToken($request->header('token'));
        if($token->checkToken()) {
            return $company;
        } 
        return response()->json(['message'=>'Not logged in'],401);
    }

    public function store(Request $request) {

        $token = new Token;
        $token->setToken($request->header('token'));
        if($token->checkToken()) {
            $company = Company::create($request->all());

            return response()->json($company, 201);
        } 
        return response()->json(['message'=>'Not logged in'],401);
    }

    public function update(Request $request, Company $company) {

        $token = new Token;
        $token->setToken($request->header('token'));
        if($token->checkToken()) {
            $company->update($request->all());

            return response()->json($company, 200);
        } 
        return response()->json(['message'=>'Not logged in'],401);
    }

    public function delete(Request $request, Company $company) {

        $token = new Token;
        $token->setToken($request->header('token'));
        if($token->checkToken()) {
            $company->delete();

            return response()->json(null, 204);
        } 
        return response()->json(['message'=>'Not logged in'],401);

    }
}
