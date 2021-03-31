<?php

namespace App\Http\Models;

use DB;
use Session;
use Illuminate\Database\Eloquent\Model;

class EmployeeModel extends Model {

    public function getLookup($code) {
        $set = DB::select("select * from lookup_set where code = '" . $code . "'");
        if (count($set) > 0) {
            $set_id = $set[0]->id;
            if ($set_id > 0) {
                $result = DB::select("select * from lookup where lookup_set_id = '" . $set_id . "' AND is_active = true");
                if (count($result) > 0) {
                    return $result;
                }
                return array();
            }
            return array();
        }
        return array();
    }

    public function getCountry() {
        $result = DB::select("select * from country where is_active = true");
        if (count($result) > 0) {
            return $result;
        }
        return array();
    }

    public function getEmployees() {
        $result = DB::select("select * from user_profile where is_active = true");
        if (count($result) > 0) {
            return $result;
        }
        return array();
    }

    public function getSingleEmployee($id) {
        $result = DB::select("select * from user_profile where is_active = true and id = " . $id);
        if (count($result) > 0) {
            return $result;
        }
        return array();
    }

    public function getCountryLocation($country) {
        $set = DB::select("select * from region where country_code = " . $country . " AND is_active = true");
        if (count($set) > 0) {
            $set_id = $set[0]->id;
            if ($set_id > 0) {
                $result = DB::select("select * from location where region = '" . $set_id . "'");
                if (count($result) > 0) {
                    return $result;
                }
                return array();
            }
            return array();
        }
        return array();
    }

    public function saveProfile($param, $id) {
        $modified_date = date('d-m-Y h:i A');
        $created_date = date('d-m-Y h:i A');

        if ($id == 0) { //add
            $chkMail = DB::select("select * from user_profile where email = '" . $param['email'] . "' AND is_active = true");
            if (count($chkMail) > 0) {
                return 3; //email already exist 
            }
            DB::table("user_profile")->insert($param);
            $empID=DB::getPdo()->lastInsertId();
            $user_id=$empID;
            $subject='Employee Created';
            $message=$param['firstname'].' '.$param['lastname'].' has been created on '.$created_date.' by '.Session::get('user-full-name').' Please use the below credentials to login : email: '.$param['email'].' password :' .$param['password'];  
        } else { //edit
            DB::table('user_profile')
                    ->where('id', $id)
                    ->update($param);
                    $user_id=$id;
                    $subject='Employee Updated';
                    $message=$param['firstname'].' '.$param['lastname']. ' has been updated on '.$modified_date.' by '.Session::get('user-full-name');   
        }
        $resEmp = app('App\Http\Models\EmployeeModel')->getEmployees();
        foreach ($resEmp as $user) {
            $emailInput = array(
                'user_id'=>   $user->id,
                'email_to'=> $user->email,
                'notify_type'=> 'Employee',
                'notify_status'=> 1,
                'type_id'=>$user_id,
                'is_active'=>true,
                'subject' =>$subject,
                'message' => $message
                );
                

                
                if ($id == 0) {
                    $emailInput['created_by'] = Session::get('user-id');
                    $emailInput['created_date'] =  date('Y-m-d H:i:s');
                } else {
                    $emailInput['modified_by'] = Session::get('user-id');
                    $emailInput['modified_date'] =  date('Y-m-d H:i:s');
                }
                app('App\Http\Controllers\EmailController')->createEmail($emailInput);
            }
        return 1;
    }

    public function deleteEmployee($id) {
        $param = array('is_active' => false);
        $res = app('App\Http\Models\EmployeeModel')->getSingleEmployee($id);
        $modified_date = date('d-m-Y h:i A');
        $message=$res['0']->firstname.' '.$res['0']->lastname.' has been deleted on '.$modified_date.' by ';    
        DB::table('user_profile')
                ->where('id', $id)
                ->update($param);
                $res = app('App\Http\Models\EmployeeModel')->getEmployees();
                foreach ($res as $user) {
                    $emailInput = array(
                        'user_id'=>   $user->id,
                        'email_to'=> $user->email,
                        'notify_type'=> 'Employee',
                        'notify_status'=> 1,
                        'type_id'=>$id,
                        'is_active'=>true,
                        'subject' =>'Employee Deleted',
                        'message' => $message.' '.Session::get('user-full-name'),
                        'modified_by' =>Session::get('user-id'),
                        'modified_date' =>  date('Y-m-d H:i:s')
                        );
                        $res = app('App\Http\Controllers\EmailController')->createEmail($emailInput);
                    }
        return 1;
    }

}

?>
