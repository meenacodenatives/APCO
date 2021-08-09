<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Database\Eloquent\Model;

class CountryController extends Controller
{
    // Drop down - State -customer
    public function getStates()
    {
        $result = DB::select("select * from state where is_active = true");
        if (count($result) > 0) {
            return $result;
        }
        return array();
    }
    //Region from States
    public function getRegionFromStates($stateID, $type)
    {
        $getRegion = DB::table('region')
            ->join('state', 'state.id', '=', 'region.state_id')
            ->select('region.name as regName', 'region.id as regID')
            ->where('region.country_id', '=', 1)
            ->where('region.state_id', '=', $stateID)
            ->get();
        if ($type == 'add') {
            $region = '<option value="">Select</option>';
            if (count($getRegion) > 0) {
                foreach ($getRegion as $reg) {
                    $region .= '<option value="' . $reg->regID . '"  >' . $reg->regName . '</option>';
                }
                echo $region;
            }
        } else {
            return $getRegion;
        }
    }
    //Location from Region
    public function getLocationFromRegion($regionID, $type)
    {
        $getLocation = DB::table('location')
            ->join('region', 'region.id', '=', 'location.region')
            ->select('location.name as locName', 'location.id as locID')
            ->where('location.region', '=', $regionID)
            ->get();
        if ($type == 'add') {
            $location = '<option value="">Select</option>';
            if (count($getLocation) > 0) {
                foreach ($getLocation as $loc) {
                    $location .= '<option value="' . $loc->locID . '">' . $loc->locName . '</option>';
                }
                echo $location;
            }
        } else {
            return $getLocation;
        }
    }
    // Drop down
    public function getCountries()
    {
        $res['country'] = app('App\Http\Models\EmployeeModel')->getCountry();
        $res['type'] = 'Add';
        $res['company_type'] = app('App\Http\Models\EmployeeModel')->getLookup('lead_company_type');
        $res['source'] = app('App\Http\Models\EmployeeModel')->getLookup('lead_source');
        $res['status'] = app('App\Http\Models\EmployeeModel')->getLookup('lead_status');
        $res['state'] = $this->getStates();
        $res['region'] = array();
        $res['location'] = array();
        return \View::make('add-lead')->with(["data" => $res]);
    }


    // public function getLocationFromRegion($region)
    // {
    //     $check = app('App\Http\Models\LeadModel')->getLocationFromRegion($region);

    //     if ($check->isEmpty()) {
    //         $result = array('msg' => 'No Records found', 'success' => true);
    //         $response = \Response::json($result)->setStatusCode(400, 'Fail');
    //     } else {
    //         $response = $check;
    //     }
    //     return $response;
    // }

    public function getRegionFromCountries($ctrycode)
    {
        $check = app('App\Http\Models\LeadModel')->getRegionFromCountries($ctrycode);
        if ($check->isEmpty()) {
            $result = array('msg' => 'No Records found', 'success' => true);
            $response = \Response::json($result)->setStatusCode(400, 'Fail');
        } else {
            $response = $check;
        }
        return $response;
    }
}
