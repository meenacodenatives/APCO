<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; 
use Session;
use Illuminate\Database\Eloquent\Model;

class CountryController extends Controller
{
    //country Drop down
    public function getCountries()
    {
         $countries =DB::table('country')->select('*')->where('is_active', '=', true)->get();
         $res['type']='Add';
         $res['country'] = $countries;
         $res['company_type'] = app('App\Http\Models\EmployeeModel')->getLookup('lead_company_type');
         $res['source'] = app('App\Http\Models\EmployeeModel')->getLookup('lead_source');
         return \View::make('add-lead')->with(["data" => $res]);
    }

    
    public function getLocationFromRegion($region)
    {
         $check =DB::table('region')
        ->join('location', 'location.region', '=', 'region.id')
        ->select('location.name as locName','location.id as locID')
        ->where('location.region','=',$region)
        ->get();

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
         $check =DB::table('country')
        ->join('region', 'region.country_code', '=', 'country.code')
        ->select('region.name as regName','region.id as regID')
        ->where('region.country_code','=',$ctrycode)
        ->get();

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
