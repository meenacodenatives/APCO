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
       // echo encrypt($res['lead'][10]->id); exit;
       $res['users'] = app('App\Http\Models\TrackerModel')->getUsers();

        return \View::make('leads')->with(["data" => $res]);
    //  return $res;
    }

    public function createLead(Request $request)
    {
        $lead_model = new LeadModel();

        if ($_POST['data']['country'] > 0) {

        $param = array(
        'country'=> $_POST['data']['country'],
        'region'=> $_POST['data']['region'],
        'name'=> $_POST['data']['leadName'],
        'email'=> $_POST['data']['leadEmail'],
        'phone'=>$_POST['data']['leadPhone'],
        'skype_id'=> $_POST['data']['leadSkype'],
        'website'=> $_POST['data']['leadWebsite'],
        'location'=> $_POST['data']['location'],
        'contact_name'=> $_POST['data']['leadcontactName'],
        'source'=> $_POST['data']['source'],
        'company_type'=> $_POST['data']['company_type'],
        'address'=> $_POST['data']['address'],
        'remarks'=> $_POST['data']['remarks'],
        'description'=> $_POST['data']['description'],
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
        return response()->json(array('status' => $result), 200);
    }

        return response()->json(array('status' => 0), 200);

    }
        public function editSingleLead($id)
        {
            $lead_model = new LeadModel();
            $de_id=decrypt($id);
            $res['type']='Edit';
            $res['lead'] = $lead_model->singleSelectLead($de_id);
            $res['country'] = $lead_model->getCountry();
            $res['company_type'] = app('App\Http\Models\EmployeeModel')->getLookup('lead_company_type');
            $res['source'] = app('App\Http\Models\EmployeeModel')->getLookup('lead_source');
            return \View::make('add-lead')->with(["data" => $res]);
        }
    public function deleteLead(Request $request) {
        $lead_model = new LeadModel();
        $res = $lead_model->deleteLead($_POST['data']['id']);
        return response()->json(array('status' => $res), 200);
    }
}
