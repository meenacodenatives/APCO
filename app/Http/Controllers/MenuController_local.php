<?php
namespace App\Http\Controllers;
use App\Http\Models\MenuModel;
use Illuminate\Http\Request;
use Session;
use DB;

class MenuController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeMenuUsers(Request $request)
    {
        if($_POST['data']['id']!='')
        {
             DB::table('menu_access')
            ->where('menu_id', $_POST['data']['id'])
            ->delete();
            for($i=0;$i<count($_POST['data']['user_id']);$i++)
            {
            $user_id=$_POST['data']['user_id'][$i]; 
            $user_id_category=explode('_',$user_id); 

            $param = array(
                'menu_id'=>$_POST['data']['menu_id'],
                'user_id'=>$user_id_category[1],
                'user_category'=>$user_id_category[0],
                'menu_access_status'=>'Active'
                );
                $param['menu_access_modified_by'] = Session::get('user-id');
                $param['updated_at'] = date('Y-m-d H:i:s');
                DB::table("menu_access")->insert($param);
            }
            $result=1;
        }
        else
        {   
            for($i=0;$i<count($_POST['data']['user_id']);$i++)
            {
            $user_id=$_POST['data']['user_id'][$i]; 
            $user_id_category=explode('_',$user_id); 

            $param = array(
                'menu_id'=>$_POST['data']['menu_id'],
                'user_id'=>$user_id_category[1],
                'user_category'=>$user_id_category[0],
                'menu_access_status'=>'Active'
                );
                $param['menu_access_created_by'] = Session::get('user-id');
                $param['created_date'] = date('Y-m-d H:i:s');
                DB::table("menu_access")->insert($param);
            }
            $result=1;
        }
        return response()->json(array('status' => $result), 200);
    }
    public function storeMenu(Request $request)
    {
        $p_menu=$_POST['data']['pMenu'];
        if(empty($p_menu))
        {
            $p_id=0;
            $is_child=0;
        }
        else
        {
            $p_id=$p_menu;
            $is_child=1;
        }
        $param = array(
            'menu_name'=>$_POST['data']['menuName'],
            'menu_link'=>$_POST['data']['menuLink'],
            'menu_controller'=>$_POST['data']['controllerName'],
            'menu_type'=>'User',
            'menu_parent'=>$p_id,
            'menu_status'=>'Active'
            );
        if($_POST['data']['id']!='')
        {
            $isExist = MenuModel::select("*")
            ->where("menu_name", $_POST['data']['menuName'])
            ->where("id", '!=',$_POST['data']['id'])
            ->exists();
            if ($isExist) {
            $result=3;
            }else{
                $param['menu_modified_by'] = Session::get('user-id');
                $param['updated_at'] = date('Y-m-d H:i:s');
                MenuModel::whereId($_POST['data']['id'])->update($param);
            $result=1;
            }  
        }
        else
        {
            $isExist = MenuModel::select("*")
            ->where("menu_name", $_POST['data']['menuName'])
            ->exists();
            if ($isExist) {
            $result=3;
            }else{
            $param['menu_created_by'] = Session::get('user-id');
            $param['created_at'] = date('Y-m-d H:i:s');
            $show = MenuModel::create($param);
            $result=1;
            }  
        }
        
        return response()->json(array('status' => $result), 200);
    }

    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function showMenu()
    {
        echo 'GGKK'; exit;
        DB::enableQueryLog();
        $MenuList = MenuModel::all()->sortBy("menu_order");
        $Menus = MenuModel::where('menu_parent','=', 0)->get()
         ->sortByDesc("id"); //Drop Down - Add/edit
        //  $MenuList =DB::table('menu_access')
        // ->rightjoin('menu', 'menu.id', '=', 'menu_access.menu_id')
        // ->select('menu.*',DB::raw("COUNT(menu_access.menu_id) as count_row"))
        // ->groupBy(DB::raw("menu.id"))
        // ->orderByDesc("menu.menu_order")
        // ->get();
       // ,DB::raw("ARRAY_TO_STRING(ARRAY_AGG (user_profile.firstname || ' ' || user_profile.lastname), '|') as fullname"),
       $query = DB::getQueryLog();
                      $query = end($query);
                      print_r($query);
                      exit;
        $usersCategory =DB::table('user_profile')
        ->join('user_category', 'user_category.id', '=', 'user_profile.user_category')
        ->select('user_category.id as cat_id','user_category.category_name as category_name','user_profile.username as fullname',DB::raw("ARRAY_TO_STRING(ARRAY_AGG (user_profile.id), '|') as user_p_id"))
        ->where('user_category.user_category_status','=','Active')
       // ->groupBy(DB::raw("user_category.id"))
        ->get();
        
        $users= app('App\Http\Models\TrackerModel')->getUsers();
        return view('showMenu',compact('MenuList','Menus','users','usersCategory')); 
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function showSidebar()
    {
        DB::enableQueryLog();
        $s_user_id=session('user-id');
       // $MenuList = MenuModel::all()->sortBy("menu_order");
        $Menus = MenuModel::where('menu_parent','=', 0)->get()
        ->sortByDesc("id"); 
         $MenuList =DB::table('menu_access')
        ->join('menu', 'menu.id', '=', 'menu_access.menu_id')
        ->select('menu.*')
        ->where('menu_access.user_id','=',$s_user_id)
        ->get();
        return response()->json(array('MenuList'=>$MenuList,'menu'=>$Menus), 200);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function editMenu($id)
    {
        $de_id=base64_decode($id);
        $menu = MenuModel::findOrFail($de_id); //To get particular id menu
        // $cntUsers = DB::table("menu_access")
	    // ->select('user_id')
        // ->where("menu_id", '=',$de_id)
	    // ->get(); //To get users in checkboxes
        $parentMenu = DB::table("menu")
	    ->select('id','menu_name')
	    ->get(); //To get all parent menu in drop down
        $cntUsers =DB::table('menu_access')
        ->join('user_category', 'user_category.id', '=', 'menu_access.user_category')
        ->join('user_profile', 'menu_access.user_id', '=', 'user_profile.id')
        ->select('user_category.id as cat_id','user_category.category_name as category_name',DB::raw("ARRAY_TO_STRING(ARRAY_AGG (user_profile.firstname || ' ' || user_profile.lastname), '|') as fullname"),DB::raw("ARRAY_TO_STRING(ARRAY_AGG (user_profile.id), '|') as user_p_id"))
        ->where('user_category.user_category_status','=','Active')
        ->where("menu_access.menu_id", '=',$de_id)       
        ->groupBy(DB::raw("user_category.id"))
        ->get();
        $allUsers =DB::table('user_profile')
        ->join('user_category', 'user_category.id', '=', 'user_profile.user_category')
        ->select('user_category.id as cat_id','user_category.category_name as category_name',DB::raw("ARRAY_TO_STRING(ARRAY_AGG (user_profile.firstname || ' ' || user_profile.lastname), '|') as fullname"),DB::raw("ARRAY_TO_STRING(ARRAY_AGG (user_profile.id), '|') as user_p_id"))
        ->where('user_category.user_category_status','=','Active')
        ->groupBy(DB::raw("user_category.id"))
        ->get();

        return response()->json(array('menu' => $menu,'res'=>$cntUsers,'all'=>$allUsers,'parentMenu'=>$parentMenu), 200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroyMenu(Request $request)
    {
        $menu = MenuModel::findOrFail($_POST['data']['id']);
        $menu->delete();
        $result=1;
        return response()->json(array('status' => $result), 200);
    }
}