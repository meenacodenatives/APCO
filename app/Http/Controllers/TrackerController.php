<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\TrackerModel;

use Session;
use DB;
use App\Http\Models\CronModel;

class TrackerController extends Controller
{
    
    public function __construct() {

    }
    //Save Lead Tracker
    public function saveLeadTracker(Request $request)
    {
        DB::enableQueryLog();

        $tracker_model = new TrackerModel();
        $id=$_POST['data']['lead_id'];
        $notify_users=implode(',', $_POST['data']['notify_users']);
        $param['name']=$_POST['data']['name'];
        $param['last_tracked_comment']=$_POST['data']['comment'];
        $param['last_tracked_date'] = date('Y-m-d H:i:s');
          
        $modified_date = date('d-m-Y h:i A');
        $created_date = date('d-m-Y h:i A');
        //Tracker
        $param_tracker = array(
            'comment'=> $_POST['data']['comment'],
            'lead_id'=> $id,
            'contact_type'=> $_POST['data']['contact_type'],
            'notify_users'=> $notify_users,
            'is_active'=>true,
            );
            $param_tracker['created_by'] = Session::get('user-id');
            $param_tracker['created_date'] = date('Y-m-d H:i:s');
            if($_POST['data']['lead_form']=='Tracker'){
            $param_scheduler=[];
            DB::table("lead_track")->insert($param_tracker);
            $trackID=DB::getPdo()->lastInsertId();
            }
            
    else
    {
        $s_date=strtotime($_POST['data']['scheduledDate']);
        $scheduledDate = date('Y-m-d',  $s_date);
        for($i=0;$i<count($_POST['data']['assignTo']);$i++)
        {
        $assignTo=$_POST['data']['assignTo'][$i]; 
        //Scheduler
        $param_scheduler = array(
            'user_id'=> $assignTo,
            'scheduled_on'=> $scheduledDate.' '.$_POST['data']['time'],
            'type_id'=> $_POST['data']['type_id'],
           // 'region'=> $_POST['data']['region'],
            'title'=>'Lead Track',
            'description'=> 'Lead Track on '.$_POST['data']['desc'],
            'schedule_type'=> 'Lead'
            );
            $param_scheduler['created_by'] = Session::get('user-id');
            $param_scheduler['created_date'] = date('Y-m-d H:i:s');
        //End
        //insert scheduler
        DB::table("schedular")->insert($param_scheduler);
        $schedularID=DB::getPdo()->lastInsertId();
        //insert tracker
        DB::table("lead_track")->insert($param_tracker);
            $trackID=DB::getPdo()->lastInsertId();
       //EMAIL
       $user_id=$schedularID;
       $subject='Lead Scheduler created';
       $message='Scheduler has been created for '.$param['name'].' on '.$created_date.' by';     
       $res = app('App\Http\Models\EmployeeModel')->getEmployees();
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
            // app('App\Http\Controllers\EmailController')->createEmail($emailInput);
         }
         //End of EMAIL
        }
        
    }
    //echo "E=".$trackID;exit; 
    //lead_tracker Table - created date and comment and contact type
    $lead_track =DB::table("lead_track")
    ->select(DB::raw(("to_char(lead_track.created_date,'Mon dd, YYYY HH12:MI AM') as lead_created_date")),'lead_track.contact_type as contact_type','lead_track.comment as comment','lead_track.notify_users')
    ->where('lead_track.id','=',$trackID)
    ->orderby('created_date','desc')
    ->get();
   $array1 = json_decode($lead_track, true);
   

    //lead_tracker and user_profile Table - first name and last name
    $lead_userName =DB::table('lead_track')
    ->join('user_profile', 'user_profile.id', '=', 'lead_track.created_by')
    ->select('user_profile.firstname as createdFirstName','user_profile.lastname as createdLastName')
    ->where('lead_track.id','=',$trackID)
    ->get();
    $array4 = json_decode($lead_userName, true);

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
    // app('App\Http\Controllers\EmailController')->createEmail($emailInput);
      }
      //End of EMAIL
      //user_profile Table - notifiers first name and notifiers last name
      $multiple_users=DB::select("select id,CONCAT(firstname,' ',lastname)as username FROM user_profile");
      $res['multiple_users'] = $multiple_users;
          //lead track and lead notify users
          $res['tracker'] = array_map(function($array1,$array4){  
           return  array_merge(isset($array1) ? $array1 : array(), isset($array4) ? $array4 : array());
               },
           $array1,$array4); 
        //End
        //print_r($res); exit;
     return response()->json(array('response' => $res,'status'=>1), 200);
    }
    public function getLeadTrackerList($id)
    {
        $tracker_model = new TrackerModel();
        $result = $tracker_model->trackerList($id);
       return response()->json(array('response' => $result), 200);
    }

    public function getUsers(Request $request) {
        $tracker_model = new TrackerModel();
        $res = $tracker_model->getUsers();
        return response()->json(array('data' => $res), 200);
        }
}