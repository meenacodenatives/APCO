<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\WorkOrderTrackerModel;

use Session;
use DB;
use App\Http\Models\CronModel;

class WorkOrderTrackerController extends Controller
{
    
    public function __construct() {

    }
    //Save Work Order Tracker
    public function saveWOTracker(Request $request)
    {
        DB::enableQueryLog();

        $tracker_model = new WorkOrderTrackerModel();
        
        $id=$_POST['data']['WO_id'];
        $d_id=base64_decode($id);

        $notify_users=implode(',', $_POST['data']['notify_users']);
       // $param['customer_id']=$_POST['data']['customer_id'];
        $param['last_tracked_comment']=$_POST['data']['comment'];
        $param['last_tracked_date'] = date('Y-m-d H:i:s');
          
        $modified_date = date('d-m-Y h:i A');
        $created_date = date('d-m-Y h:i A');
        //Tracker
        $param_tracker = array(
            'comment'=> $_POST['data']['comment'],
            'work_orders_id'=> $d_id,
            'contact_type'=> $_POST['data']['contact_type'],
            'notify_users'=> $notify_users,
            'is_active'=>true,
            );
            $param_tracker['created_by'] = Session::get('user-id');
            $param_tracker['created_date'] = date('Y-m-d H:i:s');
            if($_POST['data']['WO_form']=='WO'){
            $param_scheduler=[];
            DB::table("work_orders_track")->insert($param_tracker);
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
            'type_id'=> $d_id,
           // 'region'=> $_POST['data']['region'],
            'title'=>'WO Track',
            'description'=> 'WO Track on '.$_POST['data']['desc'],
            'schedule_type'=> 'WO'
            );
            $param_scheduler['created_by'] = Session::get('user-id');
            $param_scheduler['created_date'] = date('Y-m-d H:i:s');
        //End
        //insert scheduler
        DB::table("schedular")->insert($param_scheduler);
        $schedularID=DB::getPdo()->lastInsertId();
        //insert tracker
        DB::table("work_orders_track")->insert($param_tracker);
            $trackID=DB::getPdo()->lastInsertId();
       //EMAIL
    //    $user_id=$schedularID;
    //    $subject='Work Order Scheduler created';
    //    $message='Scheduler has been created for '.$param['customer_name'].' on '.$created_date.' by';     
    //    $res = app('App\Http\Models\EmployeeModel')->getEmployees();
    //      foreach ($res as $user) {
    //      $emailInput = array(
    //          'user_id'=>   $user->id,
    //          'email_to'=> $user->email,
    //          'notify_type'=> 'Work Order Scheduler',
    //          'notify_status'=> 1,
    //          'type_id'=>$schedularID,
    //          'is_active'=>true,
    //          'subject' =>$subject,
    //          'message' => $message.' '.Session::get('user-full-name'),
    //          'created_by'=>Session::get('user-id'),
    //           'created_date'=>date('Y-m-d H:i:s')
    //          );
            // app('App\Http\Controllers\EmailController')->createEmail($emailInput);
       //  }
         //End of EMAIL
        }
        
    }
    //echo "E=".$trackID;exit; 
    //work_orders_tracker Table - created date and comment and contact type
    $work_orders_track =DB::table("work_orders_track")
    ->select(DB::raw(("to_char(work_orders_track.created_date,'Mon dd, YYYY HH12:MI AM') as lead_created_date")),'work_orders_track.contact_type as contact_type','work_orders_track.comment as comment','work_orders_track.notify_users')
    ->where('work_orders_track.id','=',$trackID)
    ->orderby('created_date','desc')
    ->get();
   $array1 = json_decode($work_orders_track, true);
   

    //work_orders_tracker and user_profile Table - first name and last name
    $lead_userName =DB::table('work_orders_track')
    ->join('user_profile', 'user_profile.id', '=', 'work_orders_track.created_by')
    ->select('user_profile.firstname as createdFirstName','user_profile.lastname as createdLastName')
    ->where('work_orders_track.id','=',$trackID)
    ->get();
    $array4 = json_decode($lead_userName, true);

      //Edit lead
      DB::table('work_orders')
      ->where('id', $d_id)
      ->update($param);
    $user_id=$trackID;
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
    public function getWOTrackerList($id)
    {
       $d_id=base64_decode($id);
        $tracker_model = new WorkOrderTrackerModel();
        $result = $tracker_model->trackerList($d_id);
       return response()->json(array('response' => $result), 200);
    }

    public function getUsers(Request $request) {
        $tracker_model = new WorkOrderTrackerModel();
        $res = $tracker_model->getUsers();
        return response()->json(array('data' => $res), 200);
        }
}