<?php
namespace App\Http\Controllers;

use App\Http\Models\CategoryModel;
use Illuminate\Http\Request;
use Session;
use DB;

class CategoryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCategory(Request $request,CategoryModel $category)
    {
        $p_cat=$_POST['data']['parent_category'];
        if(empty($p_cat))
        {
            $p_id=0;
            $is_child=0;
        }
        else
        {
            $p_id=$p_cat;
            $is_child=1;
        }
        $param = array(
            'name'=>$_POST['data']['name'],
            'code'=>$_POST['data']['code'],
            'description'=> $_POST['data']['description'],
            'parent_category'=>$p_id,
            'is_child'=>$is_child,
            'is_active'=>true
            );
        if($_POST['data']['id']!='')
        {
            $isExist = CategoryModel::select("*")
            ->where("name", $_POST['data']['name'])
            ->where("id", '!=',$_POST['data']['id'])
            ->exists();
            if ($isExist) {
            $result=3;
            }else{
                $param['modified_by'] = Session::get('user-id');
                $param['updated_at'] = date('Y-m-d H:i:s');
                CategoryModel::whereId($_POST['data']['id'])->update($param);
            $result=1;
            }  
        }
        else
        {
            $isExist = CategoryModel::select("*")
            ->where("name", $_POST['data']['name'])
            ->exists();
            if ($isExist) {
            $result=3;
            }else{
            $param['created_by'] = Session::get('user-id');
            $param['created_date'] = date('Y-m-d H:i:s');
            $show = CategoryModel::create($param);
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
    public function showCategory()
    {
        DB::enableQueryLog();

        $allCategories = CategoryModel::all()->sortByDesc("id");;
        $categories = CategoryModel::where('parent_category','=', 0)->get()
        ->sortByDesc("id");
        // echo '<pre>';
        // print_r($categories);
        // echo '</pre>'; exit;
        return view('showCategory',compact('categories','allCategories')); 
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function editCategory($id,CategoryModel $category)
    {
        $de_id=base64_decode($id);
        $category = CategoryModel::findOrFail($de_id);
        return response()->json(array('category' => $category), 200);

    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroyCategory(Request $request)
    {
        $category = CategoryModel::findOrFail($_POST['data']['id']);
        $category->delete();
        $result=1;
        return response()->json(array('status' => $result), 200);
    }
}