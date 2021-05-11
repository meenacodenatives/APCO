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
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function showMenu()
    {
        DB::enableQueryLog();

        $MenuList = MenuModel::all()->sortByDesc("id");
        $Menus = MenuModel::where('menu_parent','=', 0)->get()
        ->sortByDesc("id");
        // echo '<pre>';
        // print_r($categories);
        // echo '</pre>'; exit;
        return view('showMenu',compact('MenuList','Menus')); 
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
        $menu = MenuModel::findOrFail($de_id);
        return response()->json(array('menu' => $menu), 200);

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