<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; 
use Session;
use Illuminate\Database\Eloquent\Model;

class CountryController extends Controller
{
    // Drop down
    public function getCountries()
    {
        $res['country'] = app('App\Http\Models\EmployeeModel')->getCountry();
         $res['type']='Add';
         $region=1;
         $res['company_type'] = app('App\Http\Models\EmployeeModel')->getLookup('lead_company_type');
         $res['source'] = app('App\Http\Models\EmployeeModel')->getLookup('lead_source');
         $res['status'] = app('App\Http\Models\EmployeeModel')->getLookup('lead_status');
        // $res['location'] = app('App\Http\Models\LeadModel')->getLocationFromRegion($region);

         return \View::make('add-lead')->with(["data" => $res]);
    }

    
    public function getLocationFromRegion($region)
    {
        $check = app('App\Http\Models\LeadModel')->getLocationFromRegion($region);

            if($check->isEmpty())
            {
                $result = array('msg' => 'No Records found', 'success' => true);
                $response = \Response::json($result)->setStatusCode(400, 'Fail');
            }
            else
            {
                $response=$check;
            }
            return $response;
    }

    public function getRegionFromCountries($ctrycode)
    {
        $check = app('App\Http\Models\LeadModel')->getRegionFromCountries($ctrycode);
            if($check->isEmpty())
            {
                $result = array('msg' => 'No Records found', 'success' => true);
                $response = \Response::json($result)->setStatusCode(400, 'Fail');
            }
            else
            {
                $response=$check;
            }
            return $response;
    }

    
}
