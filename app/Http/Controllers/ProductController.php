<?php
namespace App\Http\Controllers;
use App\Http\Models\CategoryModel;

use App\Http\Models\ProductModel;
use Illuminate\Http\Request;


use Session;
use DB;

class ProductController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addProduct(ProductModel $Product)
    {
        $product='';
        $allCategories = CategoryModel::all()->sortByDesc("id");;
        $product_type = app('App\Http\Models\EmployeeModel')->getLookup('product_inventory_type');
        $product_units = app('App\Http\Models\EmployeeModel')->getLookup('product_inventory_units');
        return view('add-product', compact('product_type','product_units','product','allCategories'));
    }
    public function chkProductPrice(Request $request,ProductModel $Product)
    {
        DB::enableQueryLog();
        if($_POST['data']['id']!='')
        {
            
            $updateExist = ProductModel::select("*")
            ->where("product_code", $_POST['data']['product_code'])
            ->where("actual_price", $_POST['data']['actual_price'])
            ->where("product_type", $_POST['data']['product_type'])
            ->where("category", $_POST['data']['category'])
            ->where("id", '!=',$_POST['data']['id'])
            ->count();
                    //  $query = DB::getQueryLog();
                    //   $query = end($query);
                    //   print_r($updateExist);
                    // echo "cc=".$updateExist; 
                    // exit;

            if ($updateExist>0) {
            $result=3;
            }else{
            $result=2;
            }  
            
        }
        else
        {
            $isExist = ProductModel::select("*")
            ->where("product_code", $_POST['data']['product_code'])
            ->where("actual_price", $_POST['data']['actual_price'])
            ->where("product_type", $_POST['data']['product_type'])
            ->where("category", $_POST['data']['category'])
            ->exists();
            if ($isExist==1) {
            $result=3;
            }else{
            $result=2;
            }  
        }
       // exit;
       return response()->json(array('status' => $result), 200);
    }
    public function storeProduct(Request $request,ProductModel $Product)
    {
        $param = array(
            'category'=>isset($_POST['data']['category']) ?$_POST['data']['category'] : '',
            'product_name'=>$_POST['data']['product_name'],
            'product_type'=> $_POST['data']['product_type'],
            'quantity'=>$_POST['data']['quantity'],
            'product_code'=>$_POST['data']['product_code'],
            'actual_price'=> $_POST['data']['actual_price'],
            'units'=>$_POST['data']['units'],
            'mfg_date'=>$_POST['data']['mfg_date'],
            'selling_price'=>!empty($_POST['data']['selling_price']) ?$_POST['data']['selling_price'] : NULL,
            'selling_price2'=>!empty($_POST['data']['selling_price2']) ?$_POST['data']['selling_price2'] :NULL,
            'selling_price3'=>!empty($_POST['data']['selling_price3']) ?$_POST['data']['selling_price3'] : NULL,
            'batch_number'=>$_POST['data']['batch_number'],
            'expiry_date'=> $_POST['data']['expiry_date'],
            'gst'=> $_POST['data']['gst'],
            'is_active'=>true
            );
            
            DB::enableQueryLog();
        if($_POST['data']['id']!='')
        {
            $param['modified_by'] = Session::get('user-id');
            $param['updated_at'] = date('Y-m-d H:i:s');
            ProductModel::whereId($_POST['data']['id'])->update($param);
            $result=1;
        }
        else
        {
            $param['created_by'] = Session::get('user-id');
            $param['created_date'] = date('Y-m-d H:i:s');
            ProductModel::create($param);
            $result=1;
        }
        //  $query = DB::getQueryLog();
        //               $query = end($query);
        //               print_r($query); exit;
        return response()->json(array('status' => $result), 200);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function showProduct(Request $request)
    {
        DB::enableQueryLog();
        $productList = ProductModel::all()->sortByDesc("id");
        $allCategories = CategoryModel::all()->sortByDesc("id");
        $product_type = app('App\Http\Models\EmployeeModel')->getLookup('product_inventory_type');
        $allProducts =ProductModel::join('category', 'category.id', '=', 'product.category')->get(['product.id as pdtID','product.created_at as pdtcreated_at','product.*','category.*'])->sortByDesc("pdtID");
               // $query = DB::getQueryLog();
        // $query = end($query);
        // print_r($query);
        // exit;
        return view('showProduct',compact('allProducts','productList','allCategories','product_type')); 
    }
    /*
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function editProduct($id,ProductModel $Product)
    {
        $de_id=base64_decode($id);
        $product = ProductModel::findOrFail($de_id);
        $allCategories = CategoryModel::all()->sortByDesc("id");

        $product_type = app('App\Http\Models\EmployeeModel')->getLookup('product_inventory_type');
        $product_units = app('App\Http\Models\EmployeeModel')->getLookup('product_inventory_units');
        return view('add-product', compact('product','product_type','product_units','allCategories'));
    }
    public function viewSingleproduct($id,ProductModel $Product)
    {
        $product =ProductModel::join('category', 'category.id', '=', 'product.category')
                ->where('product.id','=', $id)
               ->get(['category.name', 'product.*']);
        return response()->json(array('allProducts' => $product), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroyProduct(Request $request)
    {
        $Product = ProductModel::findOrFail($_POST['data']['id']);
        $Product->delete();
        $result=1;
        return response()->json(array('status' => $result), 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function searchProduct()
    {
        DB::enableQueryLog();
        $allProducts = ProductModel::all()->sortByDesc("id");
        $allCategories = CategoryModel::all()->sortByDesc("id");
        $product_type = app('App\Http\Models\EmployeeModel')->getLookup('product_inventory_type');
        return view('searchProduct',compact('allProducts','allCategories','product_type')); 
    }

    public function searchResults(Request $request)
    {
        DB::enableQueryLog();
        $productList = ProductModel::all()->sortByDesc("id");
        $allCategories = CategoryModel::all()->sortByDesc("id");
        $product_type = app('App\Http\Models\EmployeeModel')->getLookup('product_inventory_type');
        $input=$request->input(); 
        $searchFields = ['category','product_type','mfg_date','expiry_date','actual_price'];
        $allProducts = DB::table('product')
                      ->join('category', function($query)
                      use ($input,$searchFields) {
                       $query->on('category.id', '=', 'product.category') ;
                       $showAll = array_filter($_POST['data']);
                       if(empty($showAll))
                       {
                        $query->Where('product.is_active', '=', true);
                       }
                       else
                       {
                             $category=$_POST['data']['category'];
                             $product_name=$_POST['data']['product_name'];
                             $product_type=$_POST['data']['product_type'];
                             $mfg_date=$_POST['data']['mfg_date'];
                             $expiry_date=$_POST['data']['expiry_date'];
                             $actual_price=$_POST['data']['actual_price'];
                         if ($category) {
                             $query->Where('category', '=', '' . $category . '');
                         }
                         if ($product_name) {
                             $query->Where('product_name', 'like', '%' .$product_name. '%');
                         }
                         if ($product_type) {
                             $query->Where('product_type', '=', '' . $product_type . '');
                         }
                         if ($mfg_date) {
                             $query->Where('mfg_date', '=', '' . $mfg_date . '');
                         }
                         if ($expiry_date) {
                             $query->Where('expiry_date', '=', '' . $expiry_date . '');
                         }
                         if ($actual_price) {
                             $query->Where('actual_price', '=', '' . $actual_price . '');
                         }
                         $query->Where('product.is_active', '=', true);

                        }
                          })
                          
                      ->get(['category.name', 'product.*'])
                      ->sortByDesc("id");
    //                                   $query = DB::getQueryLog();
    //                   $query = end($query);
    //                   print_r($query);
// if($allProducts->count() > 0 )
// {
//     $result = array();
// $i=0;
// // foreach($allProducts as $pt)
// // {
// //  //$result[] = $pt->name;
// // $result ='<tr><td>';
// // $result[$i].= $pt->product_name;
// // $result.='</td></tr>';
// // $i++;

// // } 
// }
// else
// {
// $product ='<tr><td colspan="8" class="span12 text-center">No Records Found</td></tr>';
// }

//print_r($result); exit;
 return response()->json(array('allProducts' => $allProducts), 200);

    }
}