<?php
namespace App\Http\Controllers;
use App\Http\Models\EmployeeGroupModel;
use Illuminate\Http\Request;
use Session;
use DB;

class EmployeeGroupController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeEmpGroupUsers(Request $request)
    {
        if($_POST['data']['id']!='')
        {
             DB::table('user_group_map')
            ->where('group_id', $_POST['data']['id'])
            ->delete();
            for($i=0;$i<count($_POST['data']['user_id']);$i++)
            {
            $user_id=$_POST['data']['user_id'][$i]; 
            $param = array(
                'group_id'=>$_POST['data']['group_id'],
                'user_id'=>$user_id,
                'group_map_status'=>'Active'
                );
                $param['modified_by'] = Session::get('user-id');
                $param['updated_at'] = date('Y-m-d H:i:s');
                DB::table("user_group_map")->insert($param);
            }
            $result=1;
        }
        else
        {   
            for($i=0;$i<count($_POST['data']['user_id']);$i++)
            {
            $user_id=$_POST['data']['user_id'][$i]; 
            $param = array(
                'group_id'=>$_POST['data']['group_id'],
                'user_id'=>$user_id,
                'group_map_status'=>'Active'
                );
                $param['created_by'] = Session::get('user-id');
                $param['created_date'] = date('Y-m-d H:i:s');
                DB::table("user_group_map")->insert($param);
            }
            $result=1;
        }
        return response()->json(array('status' => $result), 200);
    }
    public function storeEmpGroup(Request $request)
    {
          $param = array(
            'group_name'=>$_POST['data']['groupName'],
            'group_code'=>$_POST['data']['groupCode'],
            'group_status'=>'Active'
            );
        if($_POST['data']['id']!='')
        {
            $isExist = EmployeeGroupModel::select("*")
            ->where("group_name", $_POST['data']['groupName'])
            ->where("id", '!=',$_POST['data']['id'])
            ->exists();
            if ($isExist) {
            $result=3;
            }else{
                $param['group_modified_by'] = Session::get('user-id');
                $param['updated_at'] = date('Y-m-d H:i:s');
                EmployeeGroupModel::whereId($_POST['data']['id'])->update($param);
                $grpID=$_POST['data']['id'];
            $result=1;
            }  
        }
        else
        {
            $isExist = EmployeeGroupModel::select("*")
            ->where("group_name", $_POST['data']['groupName'])
            ->exists();
            if ($isExist) {
            $result=3;
            }else{
            $param['group_created_by'] = Session::get('user-id');
            $param['created_at'] = date('Y-m-d H:i:s');
            DB::table("user_group")->insert($param);
            $grpID=DB::getPdo()->lastInsertId();
            $result=1;
            }  
        }
    return response()->json(array('status' => $result,'grpID'=>$grpID), 200);
    }

    
    /**
     * Display the specified resource.
     
     * @param  \App\Models\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function showEmployeesGroup()
    {
        DB::enableQueryLog();
        $employeesGrpList =DB::table('user_group_map')
        ->join('user_group', 'user_group.id', '=', 'user_group_map.group_id')
        ->select('user_group.*',DB::raw("COUNT(user_group_map.group_id) as count_row"))
        ->groupBy(DB::raw("user_group.id"))
        ->orderByDesc("user_group.id")
        ->get();
       $users= app('App\Http\Models\TrackerModel')->getUsers();
        return view('showEmployeesGroup',compact('employeesGrpList','users')); 
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function editEmpGroup($id)
    {
        $de_id=base64_decode($id);
        $employee = EmployeeGroupModel::findOrFail($de_id);
        $cntUsers = DB::table("user_group_map")
	    ->select('user_id')
        ->where("group_id", '=',$de_id)
	    ->get();
        $users= app('App\Http\Models\TrackerModel')->getUsers();
        return response()->json(array('employee' => $employee,'users'=>$users,'res'=>$cntUsers), 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroyEmpGroup(Request $request)
    {
        $employee = EmployeeGroupModel::findOrFail($_POST['data']['id']);
        $employee->delete();
        $result=1;
        return response()->json(array('status' => $result), 200);
    }
}