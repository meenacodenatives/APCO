<?php

namespace App\Http\Models;

use DB;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class TrackerModel extends Model
{

   public function getUsers() {
            //userProfile
      $users =DB::table('user_profile')->select('*')->where('is_active', '=', true)->get();
     // $n_users = json_decode($users, true);

      if (count($users) > 0) {
         return $users;

      }
  }
   public function saveLeadTracker($param,$param_tracker,$param_scheduler,$id) 
   {
      //Tracker
      DB::table("lead_track")->insert($param_tracker);
      $trackID=DB::getPdo()->lastInsertId();
      //Edit lead
      DB::table('lead')
      ->where('id', $id)
      ->update($param);
      //insert scheduler
      DB::table("schedular")->insert($param_scheduler);
      $schedularID=DB::getPdo()->lastInsertId();
         DB::getQueryLog(); // Show results of log
   
      //GET LAST ROW
      // user_profile table Notify Users - Name
      $user_name =DB::table("lead_track")
      ->join('user_profile', 'user_profile.id', '=', 'lead_track.created_by')
      ->select('user_profile.firstname as notifiersFirstName','user_profile.lastname as notifiersLastName')
      ->where('lead_track.id','=',$trackID)
      ->whereIn('user_profile.id', [2, 1, 3, 4, 5])
      ->get();
      //lead_tracker Table - created date and comment and contact type
      $lead_track =DB::table("lead_track")
      ->select(DB::raw(("to_char(lead_track.created_date,'Mon dd, YYYY HH12:MI AM') as lead_created_date")),'lead_track.contact_type as contact_type','lead_track.comment as comment','lead_track.notify_users')
      ->where('lead_track.id','=',$trackID)
      ->orderby('created_date','desc')
      ->get();

     $array2 = json_decode($user_name, true);
     $array1 = json_decode($lead_track, true);
     //lead track and lead notify users
     $array3 = array_map(function($array1,$array2){  
      return  array_merge(isset($array1) ? $array1 : array(), isset($array2) ? $array2 : array());
          },
      $array1,$array2);  
//lead_tracker and user_profile Table - first name and last name
         $lead_userName =DB::table('lead_track')
         ->join('user_profile', 'user_profile.id', '=', 'lead_track.created_by')
         ->select('user_profile.firstname as createdFirstName','user_profile.lastname as createdLastName')
         ->where('lead_track.id','=',$trackID)
         ->get();
         $array4 = json_decode($lead_userName, true);

      //lead track and lead notify users
      $res['tracker'] = array_map(function($array3,$array4){  
         return  array_merge(isset($array3) ? $array3 : array(), isset($array4) ? $array4 : array());
             },
         $array3,$array4); 
       
      //   $schedular =DB::table('schedular')
      //   ->join('user_profile', 'user_profile.id', '=', 'schedular.user_id')
      //   ->join('region', 'region.id', '=', 'schedular.region')
      //   ->select('region.name as regionName','schedular.scheduled_on as scheduled_on','user_profile.firstname as assignFirstName','user_profile.lastname as assignLastName')
      //   ->where('schedular.id','=',$schedularID)
      //   ->get();
      //     if (count($tracker) > 0) {
      //         $res['schedular'] = $schedular;

      //     }
      //End
      return $res;
    }

   public function trackerList($id) {
      //lead_tracker Table - notify users
      $get_notify_users =DB::select("select notify_users from lead_track lt where lt.lead_id=".$id);
      $count = count($get_notify_users);
      $multiple_nu=array();
      // $query = DB::select("select id,CONCAT(firstname,' ',lastname)as username FROM user_profile");
      // foreach ($query as $key=>$r) {
      //    $result[$r->id] = $r->username;
      // }
      // return $result; exit;
      for ($x = 0; $x < $count; $x++) {
         $search=$get_notify_users[$x]->notify_users;
         $searchString = ',';
         
         //user_profile Table - notifiers first name and notifiers last name
       //  if( strpos($search, $searchString) !== false ) {
            $var=explode(',',$search);
            echo '<pre>';
            echo $search;
            // $cnt_multi_nu = count($var);
            // for ($j = 0; $j < $cnt_multi_nu; $j++)
            // {
         $multiple_nu[$x]=DB::select("select CONCAT(firstname,' ',lastname)as userName FROM user_profile WHERE id IN ($search)");
            //}
         // }
         // else
         // {
         //    $multiple_nu[$x]=DB::table('user_profile')
         //    ->select(DB::raw("CONCAT(firstname,' ',lastname)as userName"))
         //    ->where('user_profile.id','=',$search)
         // ->get();
         // }
         $resArr =array();

      foreach ($multiple_nu as $key=>$item)
     {
       foreach ($item as $key1=>$value)
       {
           $resArr[]= $value;
       }

      } 
      echo '<pre>';
      $array2 = json_decode(json_encode($resArr),true);
      print_r($array2); 
     
      }
       
      
    
      //lead_tracker Table - created date and comment and contact type
      $lead_track =DB::table("lead_track")
      ->select(DB::raw(("to_char(lead_track.created_date,'Mon dd, YYYY HH12:MI AM') as lead_created_date")),'lead_track.contact_type as contact_type','lead_track.comment as comment','lead_track.notify_users')
      ->where('lead_track.lead_id','=',$id)
      ->orderby('created_date','desc')
      ->get();

     $array1 = json_decode($lead_track, true);
     //lead track and lead notify users
     $array3 = array_map(function($array1,$array2){  
      return  array_merge(isset($array1) ? $array1 : array(), isset($array2) ? $array2 : array());
          },
      $array1,$array2);  
      
      echo '<pre>';
      print_r($array3); exit;
//lead_tracker and user_profile Table - first name and last name
         $lead_userName =DB::table('lead_track')
         ->join('user_profile', 'user_profile.id', '=', 'lead_track.created_by')
         ->select('user_profile.firstname as createdFirstName','user_profile.lastname as createdLastName')
         ->where('lead_track.lead_id','=',$id)
         ->get();
         $array4 = json_decode($lead_userName, true);

      //lead track and lead notify users
      $res['tracker'] = array_map(function($array3,$array4){  
         return  array_merge(isset($array3) ? $array3 : array(), isset($array4) ? $array4 : array());
             },
         $array3,$array4);  

         //users
      $users =DB::table('user_profile')->select('*')->where('is_active', '=', true)->get();
      $res['users'] = $users;
      //Region
      $region =DB::table('region')->select('*')->where('is_active', '=', true)->get();
      $res['region'] = $region;

      $res['track_contact_type'] = app('App\Http\Models\EmployeeModel')->getLookup('lead_track_contact_type');
      return $res;
  }

}