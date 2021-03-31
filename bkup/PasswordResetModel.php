<?php

namespace App\Http\Models;

use DB;
use Session;
use Illuminate\Database\Eloquent\Model;

class PasswordResetModel extends Model {
    public $resPwd;
    public function getforgotPwd($param) {
        $email=$param['email'];
        $result = DB::select("select * from user_profile where is_active = true and email = '" . $email . "'");
        if (count($result) > 0) {
            DB::table('user_profile')
            ->where('email', $email)
            ->update($param);
            $subject='Forgot Password';
            $message='Please click the below activation link to create new password';  
            $resPwd['value']=1;
            $resPwd['secret_key']=$param['secret_key'];
          //  $res['forgotPasswordLink']='http://localhost/apco/change-password/'.$param['secret_key'];   
        $res = app('App\Http\Models\EmployeeModel')->getEmployees();
        foreach ($res as $user) {
        $emailInput = array(
            'user_id'=>   $user->id,
            'email_to'=> $user->email,
            'notify_type'=> 'Forgot Password',
            'notify_status'=> 1,
            'type_id'=>$result[0]->id,
            'is_active'=>true,
            'subject' =>$subject,
            'message' => $message.' '.Session::get('user-full-name')
            );
            if ($_POST['data']['id'] == 0) {
                $emailInput['created_by'] = Session::get('user-id');
                $emailInput['created_date'] =  date('Y-m-d H:i:s');
            } else {
                $emailInput['modified_by'] = Session::get('user-id');
                $emailInput['modified_date'] =  date('Y-m-d H:i:s');
            }
            app('App\Http\Controllers\EmailController')->createEmail($emailInput);
        }
            return $resPwd;
        }
        else
        {
            return 2; //Email ID not exist
        }
        
    }   
    public function updatePwd($paramPwd)
     {
        $result = DB::select("select * from user_profile where is_active = true and secret_key = '" . $paramPwd['secret_key'] . "'");
            if (count($result) > 0) {
                $rowID=$result['0']->id; 

                $updVal = array(
                    'secret_key'=>'',
                    'password'=>$paramPwd['password']
                    );
                $update=DB::table('user_profile')
                  ->where('id', $rowID)
                  ->update($updVal);
                  $reschangePwd=1;
            $subject='Change Password';
            $message='Your password has been successfully changed';  
            $res = app('App\Http\Models\EmployeeModel')->getEmployees();
            foreach ($res as $user) {
            $emailInput = array(
                'user_id'=>   $user->id,
                'email_to'=> $user->email,
                'notify_type'=> 'Change Password',
                'notify_status'=> 1,
                'type_id'=>$result[0]->id,
                'is_active'=>true,
                'subject' =>$subject,
                'message' => $message.' '.Session::get('user-full-name')
                );
                if ($_POST['data']['id'] == 0) {
                    $emailInput['created_by'] = Session::get('user-id');
                    $emailInput['created_date'] =  date('Y-m-d H:i:s');
                } else {
                    $emailInput['modified_by'] = Session::get('user-id');
                    $emailInput['modified_date'] =  date('Y-m-d H:i:s');
                }
              app('App\Http\Controllers\EmailController')->createEmail($emailInput);
            }
            return $reschangePwd;

        }
        else
        {
            return 2; //Email ID not exist
        }
       
    }
   
}

?>