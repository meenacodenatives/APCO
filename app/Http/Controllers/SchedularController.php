<?php

//Controller for showinf users schedule details
//Created by : Codenatives
//Created date : 2020-12-21

namespace App\Http\Controllers;

use App\Http\Models\EmployeeModel;
use App\Http\Models\SchedularModel;
use Illuminate\Http\Request;
use Session;
use App\Http\Models\CronModel;
use DB;
use Illuminate\Support\Str;

class Schedularcontroller extends Controller {

    public function __construct() {
        
    }

    public function showSchedular(Request $request) {
        $schedular_model = new SchedularModel();
        $items = $schedular_model->getSchedules();
        $res['schedules'] = json_encode(array());
        if (count($items) > 0) {
            $schedules = array();
            
            foreach ($items as $sch) {
                $schedules[] = array(
                    'title' => $sch->title,
                    'start' => $sch->scheduled_on,
                    'type_id' => $sch->type_id,
                    'id' => $sch->id
                );
            }
            $res['schedules'] = json_encode($schedules);
        }
        $res['users'] = app('App\Http\Models\TrackerModel')->getUsers();
       // $res['region'] = $schedular_model->getRegion();
        return \View::make('schedular')->with($res);
    }

    public function showPopup(Request $request) {
        $res['items'] = 1;
        return \View::make('popup')->with(["data" => $res]);
    }

    public function createScheduler(Request $request)
    {
        DB::enableQueryLog();
        $s_date=strtotime($_POST['data']['sdate']);
        $scheduledDate = date('Y-m-d',  $s_date);
        $s_type=$_POST['data']['s_type'];
        $id=$_POST['data']['id'];
        $type_id=$_POST['data']['type_id'];
            //TYPE ID - LIKE LEAD ID
        $paramUpdate['type_id'] =rand(10,99);
        $sassignTo=$_POST['data']['sassignTo'];
       if(is_array($sassignTo))
       {
        $assTo=count($sassignTo);
       }
       else{
        $assTo=$sassignTo;
        $param = array(
            'title'=>$_POST['data']['stitle'],
            'scheduled_on'=> $scheduledDate.' '.$_POST['data']['stime'],
            'region'=>1,
            'description'=> $_POST['data']['sdesc'],
            'schedule_type'=>$s_type
            );
            $modified_date = date('d-m-Y h:i A');
            $param['modified_by'] = Session::get('user-id');
            $param['modified_date'] = date('Y-m-d H:i:s');
            $s_on=strtotime($param['scheduled_on']);
        $e_sch_on = date('d-m-Y h:i A',  $s_on);

    // $query = DB::getQueryLog();
    //                   $query = end($query);
    //                   print_r($query);
    DB::table('schedular')
    ->where('type_id', $type_id)
    ->update($param);
    
        }
     //Add
    if ($id == 0)
    { 
    for($i=0;$i<$assTo;$i++)
    {
        $assignTo=$sassignTo[$i]; 
        $param = array(
            'user_id'=>$assignTo,
            'title'=>$_POST['data']['stitle'],
            'scheduled_on'=> $scheduledDate.' '.$_POST['data']['stime'],
            'region'=>1,
            'type_id'=>0,
            'description'=> $_POST['data']['sdesc'],
            'schedule_type'=>$s_type
            );
        $param['created_by'] = Session::get('user-id');
        $param['created_date'] = date('Y-m-d H:i:s');
        $created_date = date('d-m-Y h:i A');
        $s_on=strtotime($param['scheduled_on']);
        $e_sch_on = date('d-m-Y h:i A',  $s_on);
        $id=$_POST['data']['id'];
        if ($id == 0) { //add
            DB::table("schedular")->insert($param);
            $scheID=DB::getPdo()->lastInsertId();
            $user_id=$scheID;
            DB::table('schedular')
                   ->where('id', $scheID)
                   ->update($paramUpdate);
            
            $subject='Scheduler Created';
            $message='Scheduler has been created for the date of '.$e_sch_on.' on '.$created_date.' by ';  
       }
    }                               
 } 
if ($id > 0 && is_array($sassignTo)) { 
    //Edit - with input data - sassign to
    DB::delete("DELETE  from schedular where  type_id = " . $type_id);
    for($i=0;$i<$assTo;$i++)
    {
        $assignTo=$sassignTo[$i]; 
        $param = array(
            'user_id'=>$assignTo,
            'title'=>$_POST['data']['stitle'],
            'scheduled_on'=> $scheduledDate.' '.$_POST['data']['stime'],
            'region'=>1,
            'type_id'=>0,
            'description'=> $_POST['data']['sdesc'],
            'schedule_type'=>$s_type
            );
            $param['created_by'] = Session::get('user-id');
            $param['created_date'] = date('Y-m-d H:i:s');
            $created_date = date('d-m-Y h:i A');
            $s_on=strtotime($param['scheduled_on']);
            $e_sch_on = date('d-m-Y h:i A',  $s_on);
            $modified_date = date('d-m-Y h:i A');
            $param['modified_by'] = Session::get('user-id');
            $param['modified_date'] = date('Y-m-d H:i:s');
            $s_on=strtotime($param['scheduled_on']);
        $e_sch_on = date('d-m-Y h:i A',  $s_on);

    
    DB::table("schedular")->insert($param);


    $user_id=$id;
    $subject='Scheduler Updated';
    $message='Scheduler has been updated for the date of '.$e_sch_on.' on '.$modified_date.' by ';  
     $result = app('App\Http\Models\EmployeeModel')->getEmployees();
       foreach ($result as $user) {
       $emailInput = array(
           'user_id'=>   $user->id,
           'email_to'=> $user->email,
           'notify_type'=> 'Scheduler',
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
        //  app('App\Http\Controllers\EmailController')->createEmail($emailInput);
       }
    }  
}

      $res=1;
       return response()->json(array('status' => $res), 200);

    }
    public function showSingleSchedular($id)
    {
        $schedular_model = new SchedularModel();
       // $res['type']='Edit';
        $result1 = $schedular_model->singleSelectSchedular($id);
        $result=$result1['schedular'];
        if($result[0]->leadName!='')
        {
            $titleLeadName=$result[0]->leadName;
        }
        else
        {
            $titleLeadName=$result[0]->title;
        }
        $currentDateTime = $result[0]->scheduled_on;
        $scheduledDateTime=explode(" ",$currentDateTime);
        $singleScheduledTime= $scheduledDateTime[1];
        //Date
        $sDate=$scheduledDateTime[0];
        //End
        $as='';
        for($i=0;$i<count($result);$i++)
        {
         $as.=$result[$i]->user_id.',';

        }
        $assTo=substr($as,0,-1);
        $array1=$assTo;
        $array = explode(',', $array1);
return response()->json(array('scheduler' => $result,'multiple_users' => $result1['multiple_users'],'titleLeadName'=>$titleLeadName,'assTo'=>$array,'sdate'=>$sDate,'stime'=>$singleScheduledTime), 200);
    }
public function deleteSchedular(Request $request) {
    $schedular_model = new SchedularModel();
    $res = $schedular_model->deleteSchedular($_POST['data']['id']);
    return response()->json(array('status' => $res), 200);
}


}