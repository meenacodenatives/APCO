<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Http\Models\CronModel;

class Dashboardcontroller extends Controller {

    public function __construct() {
        
    }

    public function showDashboard(Request $request) {
        return \View::make('index');
    }

    public function doLogout(Request $request) {
        Session::flush();
        return redirect('login');
    }

}
