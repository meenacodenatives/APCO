<?php
//Controller for handling Lead module CRUD Operations
//Created by codenatives
//Created date - 10-12-2020
namespace App\Http\Controllers;
use App\Http\Models\LeadModel;

use Illuminate\Http\Request;
use Session;
use DB;
use App\Http\Models\CronModel;

class LeadController extends Controller
{
    //
    public $successStatus = 200;
    public function __construct() {
    }

    public function showLogin(Request $request) {
       return \View::make('login');
    }

    public function showLead(Request $request) {
        $lead_model = new LeadModel();
        $res['lead'] = $lead_model->getAllLead();
        $res['status'] = app('App\Http\Models\EmployeeModel')->getLookup('lead_status');
        $res['contactType'] = app('App\Http\Models\EmployeeModel')->getLookup('lead_track_contact_type');
        $res['users'] = app('App\Http\Models\TrackerModel')->getUsers();
        return \View::make('leads')->with(["data" => $res]);
    //  return $res;
    }

    public function createLead(Request $request)
    {
        DB::enableQueryLog();

        $lead_model = new LeadModel();
        $_POST['data']['country']=1;
        if ($_POST['data']['country'] > 0) {
        $param = array(
        'country'=> 1,
        'region'=>  $_POST['data']['region'],
        'state'=>  $_POST['data']['state'],
        'name'=> $_POST['data']['leadName'],
        'email'=> $_POST['data']['leadEmail'],
        'phone'=>!empty($_POST['data']['leadPhone']) ?$_POST['data']['leadPhone'] : NULL,
        'skype_id'=>!empty($_POST['data']['leadSkype']) ?$_POST['data']['leadSkype'] : NULL,
        'website'=> !empty($_POST['data']['leadWebsite']) ?$_POST['data']['leadWebsite'] : NULL,
        'location'=> $_POST['data']['location'],
        'contact_name'=> $_POST['data']['leadcontactName'],
        'source'=> $_POST['data']['source'],
        'status'=> $_POST['data']['status'],
        'company_type'=>!empty($_POST['data']['company_type']) ?$_POST['data']['company_type'] : NULL,
        'address'=> !empty($_POST['data']['address']) ?$_POST['data']['address'] : NULL,
        'remarks'=>!empty($_POST['data']['remarks']) ?$_POST['data']['remarks'] : NULL, 
        'description'=>!empty($_POST['data']['description']) ?$_POST['data']['description'] : NULL, 
        'is_active'=>true
        );
        if ($_POST['data']['id'] == '0') {
            $param['created_by'] = Session::get('user-id');
            $param['created_date'] = date('Y-m-d H:i:s');
            } else {
                $param['modified_by'] = Session::get('user-id');
                $param['modified_date'] = date('Y-m-d H:i:s');
            }
        $result = $lead_model->saveLead($param, $_POST['data']['id']);
//         print_r($param);
//        $query = DB::getQueryLog();
// $query = end($query);
// print_r($query); exit;
        return response()->json(array('status' => $result), 200);
    }
    return response()->json(array('status' => 0), 200);
    }
        public function editSingleLead($id)
        {
            $lead_model = new LeadModel();
            $de_id=base64_decode($id);
            $res['type']='Edit';
           // $region=1;
            $res['lead'] = $lead_model->singleSelectLead($de_id);
          //  print_r($res['lead']);
        $rowStateID=$res['lead'][0]->state;
        $rowLocationID=$res['lead'][0]->region;

           // $res['location'] = app('App\Http\Models\LeadModel')->getLocationFromRegion($region);
            $res['status'] = app('App\Http\Models\EmployeeModel')->getLookup('lead_status');
            $res['company_type'] = app('App\Http\Models\EmployeeModel')->getLookup('lead_company_type');
            $res['source'] = app('App\Http\Models\EmployeeModel')->getLookup('lead_source'); 
            $res['state'] =app('App\Http\Controllers\CountryController')->getStates();
            $res['region'] =app('App\Http\Controllers\CountryController')->getRegionFromStates($rowStateID,'edit');
            $res['location'] =app('App\Http\Controllers\CountryController')->getLocationFromRegion($rowLocationID,'edit');

           // print_r($res); exit;
            return \View::make('add-lead')->with(["data" => $res]);
        }
    public function deleteLead(Request $request) {
        $lead_model = new LeadModel();
        $res = $lead_model->deleteLead($_POST['data']['id']);
        return response()->json(array('status' => $res), 200);
    }

    public function viewSinglelead($id)
    {
        $lead_model = new LeadModel();
        $res = $lead_model->singleSelectLead($id);
        return response()->json(array('lead' => $res), 200);
    }
    public function leadSearchResults(Request $request)
    {
        DB::enableQueryLog();
        $res['leadStatus'] = app('App\Http\Models\EmployeeModel')->getLookup('lead_status');
        $input=$request->input(); 
        $searchFields = ['created_date','leadcontactName','name','email','phone','status'];

        $res['lead'] = DB::table('lead')
                      ->where(function($query)
                      use ($input,$searchFields) {
                       $showAll = array_filter($_POST['data']);
                       if(empty($showAll))
                       {
                        $query->Where('lead.is_active', '=', true);
                       }
                       else
                       {
                             $leadName=$_POST['data']['leadName'];
                             $leadEmail=$_POST['data']['leadEmail'];
                             $leadcontactName=$_POST['data']['leadcontactName'];
                             $leadPhone=$_POST['data']['leadPhone'];
                             if(empty($_POST['data']['leadStatus']))
                             {
                                $leadStatus='';
                             }
                             else
                             {
                                $leadStatus=$_POST['data']['leadStatus'];
                             }
                             $from=$_POST['data']['from'];
                             $to=$_POST['data']['to'];

                         if ($leadName) {
                             $query->Where('name', 'like', '%' .$leadName. '%');
                         }
                         if ($leadEmail) {
                             $query->Where('email', '=', '' . $leadEmail . '');
                         }
                         if ($leadcontactName) {
                            $query->Where('contact_name', '=', '' . $leadcontactName . '');
                        }
                         if ($leadPhone) {
                             $query->Where('phone', '=', '' . $leadPhone . '');
                         }
                         if ($leadStatus) {
                             $query->WhereIn('status',  $leadStatus);
                         }
                         if ($from) {
                            $query->Where('created_date', '>=', '' . $from . '');
                            $query->orWhere('created_date', '<=', '' . $to . '');

                          // $query->whereBetween('created_date', [$from, $to]);
                         }
                         $query->Where('lead.is_active', '=', true);

                        }
                          })
                      ->get(['lead.*'])
                      ->sortByDesc("id");
                    //   $query = DB::getQueryLog();
                    //   $query = end($query);
                    //   print_r($query); exit;
//print_r($result); 
 return response()->json(array('result' => $res), 200);

    }
}
