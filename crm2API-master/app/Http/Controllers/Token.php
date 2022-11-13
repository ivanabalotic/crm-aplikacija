<?php

namespace App\Http\Controllers;
use  App\Models\Staff;

class Token {
    
    private $token;

    public function setToken($token) {
        $this->token = $token;
    }

    public function getToken() {
        return $this->token;
    }

    public function checkToken() {
        $staff =  Staff::all();
        foreach($staff as $s) {
            if($s->api_token == $this->token) {
                return true;
            }
        } 
        return false;
    }
}