<?php

namespace App\Http\Models;

use DB;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class RFQTrackerModel extends Model
{

   public function getUsers() 
   {
      //userProfile
      $users =DB::table('user_profile')->select('*')->where('is_active', '=', true)->get();
      if (count($users) > 0) {
         return $users;
      }
   }
   

   public function trackerList($id) {
       //rfq_tracker Table - created date and comment and contact type
       $rfq_track =DB::table("rfq_track")
       ->select(DB::raw(("to_char(rfq_track.created_date,'Mon dd, YYYY HH12:MI AM') as lead_created_date")),'rfq_track.contact_type as contact_type','rfq_track.comment as comment','rfq_track.notify_users')
       ->where('rfq_track.rfq_id','=',$id)
       ->orderby('created_date','desc')
       ->get();
      $array1 = json_decode($rfq_track, true);
      //user_profile Table - notifiers first name and notifiers last name
      $multiple_users=DB::select("select id,CONCAT(firstname,' ',lastname)as username FROM user_profile");
      
      $res['multiple_users'] = $multiple_users;

//rfq_tracker and user_profile Table - first name and last name
         $lead_userName =DB::table('rfq_track')
         ->join('user_profile', 'user_profile.id', '=', 'rfq_track.created_by')
         ->select('user_profile.firstname as createdFirstName','user_profile.lastname as createdLastName')
         ->where('rfq_track.rfq_id','=',$id)
         ->get();
         $array4 = json_decode($lead_userName, true);

      //lead track and lead notify users
      $res['tracker'] = array_map(function($array1,$array4){  
         return  array_merge(isset($array1) ? $array1 : array(), isset($array4) ? $array4 : array());
             },
         $array1,$array4);  

         //users - Notified To
      $users =DB::table('user_profile')->select('*')->where('is_active', '=', true)->get();
      $res['users'] = $users;
      //Region
      // $region =DB::table('region')->select('*')->where('is_active', '=', true)->get();
      // $res['region'] = $region;

      $res['track_contact_type'] = app('App\Http\Models\EmployeeModel')->getLookup('rfq_track_contact_type');
      return $res;
  }

}