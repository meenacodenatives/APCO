<?php

//Controller for handling login,redirect dashboard if session
//Handling forgot password and reset password features
//Created by : Codenatives
//Created date : 2020-12-10

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Http\Models\LoginModel;
use App\Http\Models\CronModel;

class Logincontroller extends Controller { //login controller

    public function __construct() { //constructor
    }

    public function showLogin(Request $request) { //show login page if no session and app launch
        return \View::make('login');
    }

    public function doLogin(Request $request) { //authenticate process
        $login_model = new LoginModel();
        if ($_POST['data']['email'] != '') {
            $res = $login_model->checkAuthentication($_POST);
            if (is_array($res) && count($res) > 0) {
                $request->session()->put('user-id', $res[0]->id);
                $request->session()->put('user-full-name', $res[0]->firstname.' '.$res[0]->lastname);
                $res = 1;
            }
        }
        return response()->json(array('status' => $res), 200);
    }

}
