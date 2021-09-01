<?php

namespace App\Http\Models;

use DB;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class TrackerModel extends Model
{
   public function getUsers() 
   {
      DB::enableQueryLog();

      //userProfile
      $users =DB::table('user_profile')->select('*')->where('is_active', '=', true)->get();
      if (count($users) > 0) {
         return $users;
      }
      // $query = DB::getQueryLog();
      //                 $query = end($query);
      //                 print_r($query); exit;
      return array();

   }
   public function saveLeadTracker($param,$param_tracker,$param_scheduler,$id) 
   {
      $modified_date = date('d-m-Y h:i A');
      $created_date = date('d-m-Y h:i A');
    
      DB::table("lead_track")->insert($param_tracker);
      $trackID=DB::getPdo()->lastInsertId();
        //Edit lead
        DB::table('lead')
        ->where('id', $id)
        ->update($param);
      $user_id=$trackID;
      $subject='Lead Tracker Created';
      $message='Tracker has been created for '.$param['name'].' on '.$created_date.' by';     
      //EMAIL
      $res = app('App\Http\Models\EmployeeModel')->getEmployees();
        foreach ($res as $user) {
        $emailInput = array(
            'user_id'=>   $user->id,
            'email_to'=> $user->email,
            'notify_type'=> 'Lead Tracker',
            'notify_status'=> 1,
            'type_id'=>$user_id,
            'is_active'=>true,
            'subject' =>$subject,
            'message' => $message.' '.Session::get('user-full-name'),
            'created_by'=>Session::get('user-id'),
            'created_date'=>date('Y-m-d H:i:s')
            );
       app('App\Http\Controllers\EmailController')->createEmail($emailInput);
        }
        //End of EMAIL
      //insert scheduler
      DB::table("schedular")->insert($param_scheduler);
      $schedularID=DB::getPdo()->lastInsertId();
     //EMAIL
     $user_id=$schedularID;
     $subject='Lead Scheduler created';
     $message='Scheduler has been created for '.$param['name'].' on '.$created_date.' by';     
     app('App\Http\Models\EmployeeModel')->getEmployees();
       foreach ($res as $user) {
       $emailInput = array(
           'user_id'=>   $user->id,
           'email_to'=> $user->email,
           'notify_type'=> 'Lead Scheduler',
           'notify_status'=> 1,
           'type_id'=>$schedularID,
           'is_active'=>true,
           'subject' =>$subject,
           'message' => $message.' '.Session::get('user-full-name'),
           'created_by'=>Session::get('user-id'),
            'created_date'=>date('Y-m-d H:i:s')
           );
           app('App\Http\Controllers\EmailController')->createEmail($emailInput);
       }
       //End of EMAIL
      //lead_tracker Table - created date and comment and contact type
      $lead_track =DB::table("lead_track")
      ->select(DB::raw(("to_char(lead_track.created_date,'Mon dd, YYYY HH12:MI AM') as lead_created_date")),'lead_track.contact_type as contact_type','lead_track.comment as comment','lead_track.notify_users')
      ->where('lead_track.id','=',$trackID)
      ->orderby('created_date','desc')
      ->get();
     $array1 = json_decode($lead_track, true);
       //user_profile Table - notifiers first name and notifiers last name
       $multiple_users=DB::select("select id,CONCAT(firstname,' ',lastname)as username FROM user_profile");
       $res['multiple_users'] = $multiple_users;

      //lead_tracker and user_profile Table - first name and last name
      $lead_userName =DB::table('lead_track')
      ->join('user_profile', 'user_profile.id', '=', 'lead_track.created_by')
      ->select('user_profile.firstname as createdFirstName','user_profile.lastname as createdLastName')
      ->where('lead_track.id','=',$trackID)
      ->get();
      $array4 = json_decode($lead_userName, true);
        //lead track and lead notify users
        $res['tracker'] = array_map(function($array1,$array4){  
         return  array_merge(isset($array1) ? $array1 : array(), isset($array4) ? $array4 : array());
             },
         $array1,$array4); 
      //End
      return $res;
    }

   public function trackerList($id) {
       //lead_tracker Table - created date and comment and contact type
       $lead_track =DB::table("lead_track")
       ->select(DB::raw(("to_char(lead_track.created_date,'Mon dd, YYYY HH12:MI AM') as lead_created_date")),'lead_track.contact_type as contact_type','lead_track.comment as comment','lead_track.notify_users')
       ->where('lead_track.lead_id','=',$id)
       ->orderby('created_date','desc')
       ->get();
      $array1 = json_decode($lead_track, true);
      //user_profile Table - notifiers first name and notifiers last name
      $multiple_users=DB::select("select id,CONCAT(firstname,' ',lastname)as username FROM user_profile");
      
      $res['multiple_users'] = $multiple_users;

//lead_tracker and user_profile Table - first name and last name
         $lead_userName =DB::table('lead_track')
         ->join('user_profile', 'user_profile.id', '=', 'lead_track.created_by')
         ->select('user_profile.firstname as createdFirstName','user_profile.lastname as createdLastName')
         ->where('lead_track.lead_id','=',$id)
         ->get();
         $array4 = json_decode($lead_userName, true);

      //lead track and lead notify users
      $res['tracker'] = array_map(function($array1,$array4){  
         return  array_merge(isset($array1) ? $array1 : array(), isset($array4) ? $array4 : array());
             },
         $array1,$array4);  

         //users
      $users =DB::table('user_profile')->select('*')->where('is_active', '=', true)->get();
      $res['users'] = $users;
      //Region
      // $region =DB::table('region')->select('*')->where('is_active', '=', true)->get();
      // $res['region'] = $region;

      $res['track_contact_type'] = app('App\Http\Models\EmployeeModel')->getLookup('lead_track_contact_type');
      return $res;
  }

}