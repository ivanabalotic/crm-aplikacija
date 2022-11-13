<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Controllers\Token;

class ContactController extends Controller
{
    public function index(Request $request) {
        $token = new Token;
        $token->setToken($request->header('token'));
        if($token->checkToken()) {
            return Contact::all();
        } 
        return response()->json(['message'=>'Not logged in'],401);

    }

    public function indexJoin(Request $request) {

        $token = new Token;
        $token->setToken($request->header('token'));
        if($token->checkToken()) {
            $contacts = DB::table('contacts')->join('stages','contacts.stage_id','=', 'stages.id')
            ->join('staff','contacts.staff_id','=','staff.id')->join('companies', 'contacts.company_id', '=', 'companies.id')
            ->join('staff as cs', 'companies.staff_id' , '=', 'cs.id')
            ->join('cities','companies.city_id', 'cities.id')
            ->select('contacts.id', 'first_name', 'last_name', 'title', 'deal_size','follow_up_date', 'phone',
                'contacts.email', 'contact_method', 'notes','companies.company','companies.address',
                'companies.address2','companies.website_url','companies.city_id','companies.staff_id as company_staff_id' ,
                'stages.stage', 'stages.stage' ,'staff.name as contact_added_by', 'stage_id', 'contacts.staff_id as contact_staff_id',
                'cs.name as company_added_by', 'cities.city as company_city', 'companies.id as company_id', 'contacts.staff_id')
                ->get();
            return $contacts;
        } 
        return response()->json(['message'=>'Not logged in'],401);
    }

    public function companiesTableJoin(Request $request) {

        $token = new Token;
        $token->setToken($request->header('token'));
        if($token->checkToken()) {
            $companies = DB::table('contacts')
            ->rightJoin('companies as com', 'contacts.company_id','=', 'com.id')
            ->join('cities as cit', 'com.city_id', '=', 'cit.id')
            ->select('com.id','com.company', 'com.address', 'com.address2', 
                'com.website_url', 'cit.city as company_city'
                  ,DB::raw('SUM(contacts.deal_size) as company_deal_size')
                )

             ->groupBy('com.id', 'com.company', 'com.address', 'com.address2', 'com.website_url', 'cit.city')
            ->get();

            

            return $companies;
        } 
        return response()->json(['message'=>'Not logged in'],401);
    }

    public function show(Contact $contact, Request $request) {
        
        $token = new Token;
        $token->setToken($request->header('token'));
        if($token->checkToken()) {
            return $contact;
        } 
        return response()->json(['message'=>'Not logged in'],401);
    }

    public function showJoin(Contact $contact, Request $request) {
        
        $token = new Token;
        $token->setToken($request->header('token'));
        if($token->checkToken()) {

            $contactReq = DB::table('contacts')->join('stages','contacts.stage_id','=', 'stages.id')
            ->join('staff','contacts.staff_id','=','staff.id')->join('companies', 'contacts.company_id', '=', 'companies.id')
            ->join('staff as cs', 'companies.staff_id' , '=', 'cs.id')
            ->join('cities','companies.city_id', 'cities.id')
            ->select('contacts.id', 'first_name', 'last_name', 'title', 'deal_size','follow_up_date', 'phone',
                'contacts.email', 'contact_method', 'notes','companies.company','companies.address',
                'companies.address2','companies.website_url','companies.city_id','companies.staff_id as company_staff_id' ,
                'stages.stage', 'stages.stage' ,'staff.name as contact_added_by', 'stage_id', 'contacts.staff_id as contact_staff_id',
                'cs.name as company_added_by', 'cities.city as company_city', 'companies.id as company_id')
                ->where('contacts.id', '=', strval($contact->id)               )
                ->get();
            return $contactReq;

        } 
        return response()->json(['message'=>'Not logged in'],401);
    }

    public function store(Request $request) {

        $token = new Token;
        $token->setToken($request->header('token'));
        if($token->checkToken()) {
            $contact = Contact::create($request->all());

            return response()->json($contact, 201);
        } 
        return response()->json(['message'=>'Not logged in'],401);
    }

    public function update(Request $request, Contact $contact) {

        $token = new Token;
        $token->setToken($request->header('token'));
        if($token->checkToken()) {
            $contact->update($request->all());

            return response()->json($contact, 200);
        } 
        return response()->json(['message'=>'Not logged in'],401);
    }

    public function delete(Request $request, Contact $contact) {

        $token = new Token;
        $token->setToken($request->header('token'));
        if($token->checkToken()) {
            $contact->delete();

            return response()->json(null, 204);
        } 
        return response()->json(['message'=>'Not logged in'],401);

    }
}
