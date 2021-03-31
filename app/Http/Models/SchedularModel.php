<?php

namespace App\Http\Models;

use DB;
use Session;
use Illuminate\Database\Eloquent\Model;

class SchedularModel extends Model {

    public function getSchedules() {

       // $result = DB::select("select * from schedular where is_active = true AND user_id = '".session('user-id')."'");
       $result = DB::select("SELECT * FROM  schedular,unnest(string_to_array(user_id, ',')) AS s_user_id WHERE s_user_id = ANY ( string_to_array('".session('user-id')."', ',') ) AND is_active = true order by created_date desc" );
        if (count($result) > 0) {
            return $result;
        }
        return array();
    }

    public function saveScheduler($param,$id) {
        $modified_date = date('d-m-Y h:i A');
        $created_date = date('d-m-Y h:i A');
        $s_on=strtotime($param['scheduled_on']);
        $e_sch_on = date('d-m-Y h:i A',  $s_on);
        if ($id == 0) { //add
           DB::table("schedular")->insert($param);
           $scheID=DB::getPdo()->lastInsertId();
            $user_id=$scheID;
            $subject='Scheduler Created';
            $message='Scheduler has been created for the date of '.$e_sch_on.' on '.$created_date.' by ';  
       } else { //edit
          DB::table('schedular')
                   ->where('id', $id)
                   ->update($param);
                   $user_id=$id;
                   $subject='Scheduler Updated';
                   $message='Scheduler has been updated for the date of '.$e_sch_on.' on '.$modified_date.' by ';  
                }
     $res = app('App\Http\Models\EmployeeModel')->getEmployees();
       foreach ($res as $user) {
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
           $res = app('App\Http\Controllers\EmailController')->createEmail($emailInput);
       }
       return 1;
   }
 
   public function getRegion() {
    $result = DB::select("select * from region where is_active = true");
    if (count($result) > 0) {
        return $result;
    }
    return array();
   }

   public function singleSelectSchedular($id) {
    DB::enableQueryLog();

   //$result = DB::select("select * from schedular where is_active = true and id = " . $id);
   $res['schedular'] =DB::table('schedular')
        ->leftjoin('lead', 'lead.id', '=', 'schedular.type_id')
        ->select('lead.name as leadName','schedular.*')
       ->where('schedular.is_active', '=', true)
       ->where('schedular.id', '=', $id)
         ->get();
    //user_profile Table - notifiers first name and notifiers last name
    $multiple_users=DB::select("select id,CONCAT(firstname,' ',lastname)as username FROM user_profile");
      
    $res['multiple_users'] = $multiple_users;
    
       return $res;
    
}

public function deleteSchedular($id) {
    DB::enableQueryLog();

    $param = array('is_active' => false);
    $res = app('App\Http\Models\SchedularModel')->singleSelectSchedular($id);
        DB::table('schedular')
            ->where('type_id', $id)
            ->update($param);
                    //               $query = DB::getQueryLog();
                    //   $query = end($query);
                    //   print_r($query); exit;
      //  $modified_date = date('d-m-Y h:i A');
        // $s_on=strtotime($res['0']->scheduled_on);
        // $e_sch_on = date('d-m-Y h:i A',  $s_on);
        // $message='Scheduler has been deleted for the date of '.$e_sch_on.' on '.$modified_date.' by ';  

        // $res = app('App\Http\Models\EmployeeModel')->getEmployees();
        //         foreach ($res as $user) {
        //             $emailInput = array(
        //                 'user_id'=>   $user->id,
        //                 'email_to'=> $user->email,
        //                 'notify_type'=> 'Scheduler',
        //                 'notify_status'=> 1,
        //                 'type_id'=>$id,
        //                 'is_active'=>true,
        //                 'subject' =>'Scheduler Deleted',
        //                 'message' => $message.' '.Session::get('user-full-name'),
        //                 'modified_by' =>Session::get('user-id'),
        //                 'modified_date' => date('Y-m-d H:i:s')
        //                 );
        //                 $res = app('App\Http\Controllers\EmailController')->createEmail($emailInput);
        //             }
    return 1;
}
}

?>