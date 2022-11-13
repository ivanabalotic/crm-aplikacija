<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Token;
use Validator;

class StaffController extends Controller
{
    //

    public function index(Request $request)
    {
        $token = new Token;
        $token->setToken($request->header('token'));
        if ($token->checkToken()) {
            return Staff::all();
        }
        return response()->json(['message' => 'Not logged in'], 401);
    }

    public function indexJoin(Request $request) {

        $token = new Token;
        $token->setToken($request->header('token'));
        if($token->checkToken()) {
            $staff = DB::table('staff')
            ->join('staff as managers','staff.manager_id','=', 'managers.id')
            ->select('staff.id', 'staff.created_at','staff.updated_at',
                'staff.name','staff.email','staff.password','staff.role' ,
                'staff.status', 'staff.manager_id', 'staff.api_token','managers.name as manager')
                ->get();
            return $staff;
        } 
        return response()->json(['message'=>'Not logged in'],401);
    }

    public function show(Staff $staff, Request $request)
    {
        $token = new Token;
        $token->setToken($request->header('token'));
        if ($token->checkToken()) {
            return $staff;
        }
        return response()->json(['message' => 'Not logged in'], 401);
    }

    // public function store(Request $request) {
    //     $token = new Token;
    //     $token->setToken($request->header('token'));
    //     if($token->checkToken()) {
    //         $staff = Staff::create($request->all());

    //         return response()->json($staff, 201);
    //     } 
    //     return response()->json(['message'=>'Not logged in'],401);
    // }

    public function update(Request $request, Staff $staff)
    {

        $token = new Token;
        $token->setToken($request->header('token'));
        if ($token->checkToken()) {
            $staff->update($request->all());

            return response()->json($staff, 200);
        }
        return response()->json(['message' => 'Not logged in'], 401);
    }

    public function delete(Request $request, Staff $staff)
    {
        $token = new Token;
        $token->setToken($request->header('token'));
        if ($token->checkToken()) {
            $staff->delete();

            return response()->json(null, 204);
        }
        return response()->json(['message' => 'Not logged in'], 401);
    }

    public function login(Request $request)
    {
        // <input name="email" value="email@email.com">
        // <input name="password" value="sifra123">

        $email = $request->input('email');
        $password = $request->input('password');

        $staff = Staff::select('*')
            ->where('email', '=', $email)
            ->where('password', '=', $password)
            ->first();


        if (!isset($staff)) {
            // Nije dobra kombinacija email i password
            return response()->json(['message' => 'Bad credentials'], 401);
        }

        // napraviti token i update ga u bazi

        $token = bin2hex(random_bytes(32));
        $staff->api_token = $token;

        $staff->save();

        return response()->json($staff, 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:staff',
            'password' => 'required|confirmed', //u requestu na front strani slati "password_confirmation" polje
            'role' => 'required',
            'status' => 'required',
        ], $messages = [
            'required' => "Required field",
            'unique' => 'Email already exists'
        ]);

        if ($validator->fails()) {
            $response = $validator->errors();

            return response()->json(['message' => $response], 400);
        }

        $staff = new Staff;

        $staff->name = $request->input('name');
        $staff->email = $request->input('email');
        $staff->password = $request->input('password');
        $staff->role = $request->input('role');
        $staff->status = $request->input('status');
        $staff->manager_id = $request->input('manager_id');

        $staff->save();

        return response()->json(['message' => 'Successfully added new user.'], 200);
    }
}
