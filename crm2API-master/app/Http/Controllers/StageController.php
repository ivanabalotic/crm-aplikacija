<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stage;
use App\Http\Controllers\Token;
use  App\Models\Staff;

class StageController extends Controller
{
    
    public function index() {
        return Stage::all();
    }

    public function show(Stage $stage) {
        return $stage;  
    }
}
