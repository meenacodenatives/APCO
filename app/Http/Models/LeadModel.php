<?php

namespace App\Http\Models;

use DB;
use Session;
use Illuminate\Database\Eloquent\Model;

class LeadModel extends Model {

    public function getLocationFromRegion($region) 
    {
        $check =DB::table('region')
        ->join('location', 'location.region', '=', 'region.id')
        ->select('location.name as locName','location.id as locID')
        ->where('location.region','=',$region)
        ->get();        
        if (count($check) > 0) {
            return $check;
        }
        return array();
    }

    
    public function getAllLead() {
        $result =DB::table('lead')->select('*')->where('is_active', '=', true)
        ->orderby('created_date','desc')
      ->get();
   
   return $result;
    }

    public function singleSelectLead($id) {
        $result = DB::select("select * from lead where is_active = true and id = " . $id);
        if (count($result) > 0) {
            return $result;
        }
        return array();
    }
    public function viewSingleLeadInfo($id) {
        $result =DB::table('lead')
        ->join('state', 'state.id', '=', 'lead.state')
        ->join('region', 'region.id', '=', 'lead.region')
        ->join('location', 'location.id', '=', 'lead.location')
        ->select('*')
        ->where('lead.is_active','=',true)
        ->where('lead.id','=',$id)
        ->get();
        if (count($result) > 0) {
            return $result;
        }
        return array();
    }
    public function saveLead($param,$id) {
        $modified_date = date('d-m-Y h:i A');
        $created_date = date('d-m-Y h:i A');

        if ($id == 0) { //add
            DB::table("lead")->insert($param);
            $leadID=DB::getPdo()->lastInsertId();
            $user_id=$leadID;
            $subject='Lead Created';
            $message=$param['name'].' has been created on '.$created_date.' by';     
        } else { //edit
           DB::table('lead')
                    ->where('id', $id)
                    ->update($param);
                    $user_id=$id;
                    $subject='Lead Updated';
                    $message=$param['name'].' has been updated on '.$modified_date.' by ';     
                }
        $res = app('App\Http\Models\EmployeeModel')->getEmployees();
        foreach ($res as $user) {
        $emailInput = array(
            'user_id'=>   $user->id,
            'email_to'=> $user->email,
            'notify_type'=> 'Lead',
            'notify_status'=> 1,
            'type_id'=>$user_id,
            'is_active'=>true,
            'subject' =>$subject,
            'message' => $message.' '.Session::get('user-full-name')
            );
            if ($id == 0) {
                $emailInput['created_by'] = Session::get('user-id');
                $emailInput['created_date'] =  date('Y-m-d H:i:s');
            } else {
                $emailInput['modified_by'] = Session::get('user-id');
                $emailInput['modified_date'] =  date('Y-m-d H:i:s');
            }
            $res = app('App\Http\Controllers\EmailController')->createEmail($emailInput);
        }

            

        return 1;
    }


    public function deleteLead($id) {
        $param = array('is_active' => false);
        $res = $this->singleSelectLead($id);
        $modified_date = date('d-m-Y h:i A');
        $message=$res['0']->name.' has been deleted on '.$modified_date.' by ';     

        DB::table('lead')
                ->where('id', $id)
                ->update($param);
                $res = app('App\Http\Models\EmployeeModel')->getEmployees();
                foreach ($res as $user) {
                    $emailInput = array(
                        'user_id'=>   $user->id,
                        'email_to'=> $user->email,
                        'notify_type'=> 'Lead',
                        'notify_status'=> 1,
                        'type_id'=>$id,
                        'is_active'=>true,
                        'subject' =>'Lead Deleted',
                        'message' => $message.' '.Session::get('user-full-name'),
                        'modified_by' =>Session::get('user-id'),
                        'modified_date' => date('Y-m-d H:i:s')
                        );
                        $res = app('App\Http\Controllers\EmailController')->createEmail($emailInput);
                    }

        return 1;
    }

}

?>