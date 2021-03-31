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
        $tracker_model = new TrackerModel();
        $notify_users=implode(',', $_POST['data']['notify_users']);

        //Tracker
        $param_tracker = array(
            'comment'=> $_POST['data']['comment'],
            'lead_id'=> $_POST['data']['lead_id'],
            'contact_type'=> $_POST['data']['contact_type'],
            'notify_users'=> $notify_users,
            'is_active'=>true,
            );
            $param_tracker['created_by'] = Session::get('user-id');
            $param_tracker['created_date'] = date('Y-m-d H:i:s');
            if($_POST['data']['lead_form']=='Tracker'){
            $param_scheduler=[];
            }
    else{
        $s_date=strtotime($_POST['data']['scheduledDate']);
        $assignTo=implode(',', $_POST['data']['assignTo']);

        $scheduledDate = date('Y-m-d',  $s_date);

        //Scheduler
        $param_scheduler = array(
            'user_id'=> $assignTo,
            'scheduled_on'=> $scheduledDate.' '.$_POST['data']['time'],
            'type_id'=> $_POST['data']['type_id'],
            'region'=> $_POST['data']['region'],
            'title'=>'Lead Track',
            'description'=> 'Lead Track on '.$_POST['data']['desc'],
            'schedule_type'=> 'Lead'
            );
            $param_scheduler['created_by'] = Session::get('user-id');
            $param_scheduler['created_date'] = date('Y-m-d H:i:s');
        //End
    }

        $param['last_tracked_comment']=$_POST['data']['comment'];
        $param['last_tracked_date'] = date('Y-m-d H:i:s');
        $result = $tracker_model->saveLeadTracker($param,$param_tracker,$param_scheduler,$_POST['data']['lead_id']);
        return response()->json(array('response' => $result,'status'=>1), 200);
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