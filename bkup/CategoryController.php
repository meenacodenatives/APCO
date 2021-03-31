<?php
namespace App\Http\Controllers;

use App\Http\Models\CategoryModel;
use Illuminate\Http\Request;
use Session;

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
        $param = array(
            'name'=>$_POST['data']['name'],
            'code'=>$_POST['data']['code'],
            'description'=> $_POST['data']['description'],
            'parent_category'=>$_POST['data']['parent_category'],
            'created_by'=>Session::get('user-id'),
            'created_at'=>date('Y-m-d H:i:s')
            );

        if($_POST['data']['id']!='')
        {
            CategoryModel::whereId($_POST['data']['id'])->update($param);

        }
        else
        {
            $show = CategoryModel::create($param);

        }
        $result=1;
        return response()->json(array('status' => $result), 200);

    }

    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function showCategory(CategoryModel $category)
    {
        $categories = CategoryModel::all();
        return view('showCategory',compact('categories')); 
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