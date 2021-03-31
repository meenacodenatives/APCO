<?php

namespace App\Http\Models;

use DB;
use Session;
use Mail;

use Illuminate\Database\Eloquent\Model;

class PasswordResetModel extends Model {
    public function getforgotPwd($param) {
        $url2 = url('/');
        $email=$param['email']; 
        $result = DB::select("select * from user_profile where is_active = true and email = '" . $email . "'");
        if (count($result) > 0) {
            DB::table('user_profile')
            ->where('email', $email)
            ->update($param);
            $message1 = 'Please click the below link to create new password';
            $message= $url2.'/change-password/'.$param['secret_key'];   
            $forgotPwdDetails = array(
                    'user_name'=>$result[0]->firstname.' '.$result[0]->lastname,
                    'subject' =>'Forgot Password',
                    'message1' => $message1,
                    'message' => $message
                    );
            Mail::to($email)->send(new \App\Mail\password($forgotPwdDetails));


            $resPwd['value']=1;
            $resPwd['secret_key']=$param['secret_key'];

        // $res = app('App\Http\Models\EmployeeModel')->getEmployees();
        // foreach ($res as $user) {
        // $emailInput = array(
        //     'user_id'=>   $user->id,
        //     'email_to'=> $user->email,
        //     'notify_type'=> 'Forgot Password',
        //     'notify_status'=> 1,
        //     'type_id'=>$result[0]->id,
        //     'is_active'=>true,
        //     'subject' =>$subject,
        //     'message' => $message.' '.Session::get('user-full-name')
        //     );
        //     if ($_POST['data']['id'] == 0) {
        //         $emailInput['created_by'] = Session::get('user-id');
        //         $emailInput['created_date'] =  date('Y-m-d H:i:s');
        //     } else {
        //         $emailInput['modified_by'] = Session::get('user-id');
        //         $emailInput['modified_date'] =  date('Y-m-d H:i:s');
        //     }
        //     app('App\Http\Controllers\EmailController')->createEmail($emailInput);
        // }
        return $resPwd;

        }
        else
        {
            return 2; //Email ID not exist
        }
        
    }   
    public function updatePwd($paramPwd)
     {
        $url2 = url('/');

        $result = DB::select("select * from user_profile where is_active = true and secret_key = '" . $paramPwd['secret_key'] . "'");
            if (count($result) > 0) {
                $rowID=$result['0']->id; 
                $email=$result['0']->email;

                $updVal = array(
                    'secret_key'=>'',
                    'password'=>$paramPwd['password']
                    );
                $update=DB::table('user_profile')
                  ->where('id', $rowID)
                  ->update($updVal);
            $subject='Change Password';
            $message1='Your password has been changed successfully';
            $message2='Please click the below link to login';
            $message= $url2.'/login/';   
  
            $changePwdDetails = array(
                'user_name'=>$result[0]->firstname.' '.$result[0]->lastname,
                'subject' =>'Change Password',
                'message1' => $message1,
                'message2' => $message2,
                'message' => $message
                );
            Mail::to($email)->send(new \App\Mail\ChangePassword($changePwdDetails));

            // $res = app('App\Http\Models\EmployeeModel')->getEmployees();
            // foreach ($res as $user) {
            // $emailInput = array(
            //     'user_id'=>   $user->id,
            //     'email_to'=> $user->email,
            //     'notify_type'=> 'Change Password',
            //     'notify_status'=> 1,
            //     'type_id'=>$result[0]->id,
            //     'is_active'=>true,
            //     'subject' =>$subject,
            //     'message' => $message.' '.Session::get('user-full-name')
            //     );
            //     if ($_POST['data']['id'] == 0) {
            //         $emailInput['created_by'] = Session::get('user-id');
            //         $emailInput['created_date'] =  date('Y-m-d H:i:s');
            //     } else {
            //         $emailInput['modified_by'] = Session::get('user-id');
            //         $emailInput['modified_date'] =  date('Y-m-d H:i:s');
            //     }
            //   app('App\Http\Controllers\EmailController')->createEmail($emailInput);
            // }
            return 1;

        }
        else
        {
            return 2; //Email ID not exist
        }
       
    }
   
}

?>