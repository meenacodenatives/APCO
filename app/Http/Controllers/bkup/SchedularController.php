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
                    'id' => $sch->id
                );
            }
            $res['schedules'] = json_encode($schedules);
        }
        $res['users'] = app('App\Http\Models\TrackerModel')->getUsers();
        $res['region'] = $schedular_model->getRegion();
        return \View::make('schedular')->with($res);
    }

    public function showPopup(Request $request) {
        $res['items'] = 1;
        return \View::make('popup')->with(["data" => $res]);
    }

    public function createScheduler(Request $request)
    {
        $schedular_model = new SchedularModel();
        $s_date=strtotime($_POST['data']['sdate']);
        $scheduledDate = date('Y-m-d',  $s_date);
        $assignTo=implode(',', $_POST['data']['sassignTo']);
        $s_type='fullCalendar';
        $t_id=0;
        $param = array(
            'user_id'=>$assignTo,
            'type_id'=>$t_id,
            'title'=>$_POST['data']['stitle'],
            'scheduled_on'=> $scheduledDate.' '.$_POST['data']['stime'],
            'region'=>$_POST['data']['stimezone'],
            'description'=> $_POST['data']['sdesc'],
            'schedule_type'=>$s_type
            );
        if ($_POST['data']['id'] == 0) {
        $param['created_by'] = Session::get('user-id');
        $param['created_date'] = date('Y-m-d H:i:s');
        } else {
            $param['modified_by'] = Session::get('user-id');
            $param['modified_date'] = date('Y-m-d H:i:s');
        }
        $result = $schedular_model->saveScheduler($param, $_POST['data']['id']);
        return response()->json(array('status' => $result), 200);
    }
    public function showSingleSchedular($id)
    {
        $schedular_model = new SchedularModel();
       // $res['type']='Edit';
        $result = $schedular_model->singleSelectSchedular($id);
        $currentDateTime = $result[0]->scheduled_on;
        $scheduledDateTime=explode(" ",$currentDateTime);
        $singleScheduledTime= $scheduledDateTime[1];
        //Date
        $sDate=$scheduledDateTime[0];
        //End
        //Time
       // $newDateTime = date('h:i A', strtotime($singleScheduledTime));
        //End
        return response()->json(array('scheduler' => $result,'sdate'=>$sDate,'stime'=>$singleScheduledTime), 200);
    }
public function deleteSchedular(Request $request) {
    $schedular_model = new SchedularModel();
    $res = $schedular_model->deleteSchedular($_POST['data']['id']);
    return response()->json(array('status' => $res), 200);
}


}
