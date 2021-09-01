<?php

namespace App\Http\Models;

use DB;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class WorkOrderTrackerModel extends Model
{
   public function trackerList($id) {
       //work_orders_track Table - created date and comment and contact type
       $work_orders_track =DB::table("work_orders_track")
       ->select(DB::raw(("to_char(work_orders_track.created_date,'Mon dd, YYYY HH12:MI AM') as lead_created_date")),'work_orders_track.contact_type as contact_type','work_orders_track.comment as comment','work_orders_track.notify_users')
       ->where('work_orders_track.work_orders_id','=',$id)
       ->orderby('created_date','desc')
       ->get();
      $array1 = json_decode($work_orders_track, true);
      //user_profile Table - notifiers first name and notifiers last name
      $multiple_users=DB::select("select id,CONCAT(firstname,' ',lastname)as username FROM user_profile");
      $res['multiple_users'] = $multiple_users;
//work_orders_tracker and user_profile Table - first name and last name
         $lead_userName =DB::table('work_orders_track')
         ->join('user_profile', 'user_profile.id', '=', 'work_orders_track.created_by')
         ->select('user_profile.firstname as createdFirstName','user_profile.lastname as createdLastName')
         ->where('work_orders_track.work_orders_id','=',$id)
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
      return $res;
  }

}