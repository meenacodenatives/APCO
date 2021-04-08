<?php
namespace App\Http\Controllers;
use App\Http\Models\ProductModel;

use App\Http\Models\RFQModel;
use App\Http\Models\RFQProductsModel;
use App\Http\Models\LeadModel;
use App\Http\Models\LeadRFQMappingModel;
use Illuminate\Http\Request;


use Session;
use DB;

class RFQController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addRFQ(RFQModel $RFQ)
    {
        DB::enableQueryLog();
        $product='';$RFQProducts='';$preselectProducts=''; $lead=''; 
        $productList =DB::table('product')->select( DB::raw('DISTINCT on(product_name)product_name,id') )->where('product_type','Service')->orderBy('product_name')
        ->orderBy('id')
        ->get(['product_name','id']);
 
        // $query = DB::getQueryLog();
        //               $query = end($query);
        //               print_r($query);exit;

        $rfq_discount = app('App\Http\Models\EmployeeModel')->getLookup('rfq_discount');
     return view('add-req', compact('product','lead','RFQProducts','preselectProducts','rfq_discount','productList'));
    }
    //CREATE RFQ
    public function storeRFQ(Request $request,RFQModel $RFQ)
    {
        $param = array(
            'customer_name'=>$_POST['data']['customer_name'],
            'contact_name'=>$_POST['data']['contact_name'],
            'phone'=> $_POST['data']['phone'],
            'email'=>$_POST['data']['email'],
            'address'=>$_POST['data']['address'],
            'description'=>$_POST['data']['description'],
            'total_pdt_price'=>$_POST['data']['grdtot'],
            'labourcharge'=>$_POST['data']['labour_charge'],
            'transportcharge'=>$_POST['data']['transport_charge'],
            'margin'=>$_POST['data']['margin'],
            'proposed_value'=>$_POST['data']['proposed_value'],
            'final_value'=>$_POST['data']['final_value'],
            'discount_type'=>$_POST['data']['discount_type'],
            'discount_value'=>$_POST['data']['discount_value'],
            'amc'=>$_POST['data']['amc'],
            'is_active'=>true,
            'is_child'=>0
            );
            DB::enableQueryLog();
         //UPDATE PRODUCT AND RFQ  
        if($_POST['data']['id']!='')
        {
            // $isExist = RFQModel::select("*")
            // ->where("email", $_POST['data']['email'])
            // ->where("id", '!=',$_POST['data']['id'])
            // ->exists();
            
            // if ($isExist==1) {
            // $result=3;
            // }else{
                $RFQ = RFQModel::findOrFail($_POST['data']['id']);
                // $RFQ->delete();
                //RFQProductsModel::where('rfq_products.rfq_id',$_POST['data']['id'])->delete();
                //UPDATE QUERY - Check parent Id
                $param_track['is_child'] = 1;
                RFQModel::whereId($_POST['data']['id'])->update($param_track);
                if($RFQ->parent_id=='')
                {
                $param['parent_id'] = $_POST['data']['id'];
                $param['modified_by'] = Session::get('user-id');
                $param['updated_at'] = date('Y-m-d H:i:s');
                RFQModel::create($param);
                $rfqID=DB::getPdo()->lastInsertId();
                }
                else
                {
                $param['parent_id'] = $RFQ->parent_id;
                RFQModel::create($param);
                $rfqID=DB::getPdo()->lastInsertId();
                }
                     
                //End
            for ($i=0; $i <$_POST['data']['rowLen']; $i++) { 
                $pdt=$_POST['data']['mul_pdt_name'][$i];
                $quantity=$_POST['data']['mul_quantity'][$i];
                $units=$_POST['data']['mul_units'][$i];
                $selling_price=$_POST['data']['mul_selling_price'][$i];
                $subtotal=$_POST['data']['mul_subtotal'][$i];
                $param = array(
                    'product_id'=>$pdt,
                    'quantity'=>$quantity,
                    'units'=>$units,
                    'selling_price'=>$selling_price,
                    'subtotal'=>$subtotal,
                    'is_active'=>true,
                    'rfq_id'=>$rfqID
                    );
                DB::table("rfq_products")->insert($param);
            $result=1;
            }  
       // }
    }
        else
        {
            $isExist = RFQModel::select("*")
            ->where("email", $_POST['data']['email'])
            ->exists();
            if ($isExist==1) {
            $result=3;
            }else{
              //  if($_POST['data']['lead_id']!='')
               // {
                // $paramUpdate = array('is_active' => false);
                //  DB::table('lead')
                // ->where('id', $_POST['data']['lead_id'])
                // ->update($paramUpdate);
              //  }
            $param['created_by'] = Session::get('user-id');
            $param['created_date'] = date('Y-m-d H:i:s');
            RFQModel::create($param);
            $rfqID=DB::getPdo()->lastInsertId();
            for ($i=0; $i <$_POST['data']['rowLen']; $i++) { 
                $pdt=$_POST['data']['mul_pdt_name'][$i];
                $quantity=$_POST['data']['mul_quantity'][$i];
                $units=$_POST['data']['mul_units'][$i];
                $selling_price=$_POST['data']['mul_selling_price'][$i];
                $subtotal=$_POST['data']['mul_subtotal'][$i];
                $param = array(
                    'product_id'=>$pdt,
                    'quantity'=>$quantity,
                    'units'=>$units,
                    'selling_price'=>$selling_price,
                    'subtotal'=>$subtotal,
                    'is_active'=>true,
                    'rfq_id'=>$rfqID
                    );
                DB::table("rfq_products")->insert($param);

            }
            //Lead Creation - Direct RFQ convert into Lead table
            $param = array(
                'country'=> 1,
                'region'=> 1,
                'location'=> 6,
                'created_by' => Session::get('user-id'),
                'created_date' => date('Y-m-d H:i:s'),
                'name'=>$_POST['data']['customer_name'],
                'contact_name'=>$_POST['data']['contact_name'],
                'phone'=> $_POST['data']['phone'],
                'email'=>$_POST['data']['email'],
                'address'=>$_POST['data']['address'],
                'description'=>$_POST['data']['description'],
                'status'=>'0',
                'is_active'=>true
                );
               $lead_isExist = DB::select("select * from lead where email='" . $_POST['data']['email']."' AND phone='".$_POST['data']['phone']."'");
            if (count($lead_isExist)==0) {
                DB::table("lead")->insert($param);
                $leadID=DB::getPdo()->lastInsertId();
            }
            else
            {
                $result=3;
            }
            //lead and RFQ Mapping
            $param_mapping = array(
                'created_by' => Session::get('user-id'),
                'created_date' => date('Y-m-d H:i:s'),
                'lead_id'=>$leadID,
                'rfq_id'=>$rfqID,
                'is_active'=>true
                );
            LeadRFQMappingModel::create($param_mapping);
            $result=1;
         }
 
        }
        return response()->json(array('status' => $result), 200);
    }

    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RFQ  $RFQ
     * @return \Illuminate\Http\Response
     */
    public function showRFQ(Request $request)
    {
        DB::enableQueryLog();
        //$RFQList = RFQModel::all()->sortByDesc("id");
        $parent_id='';
        $RFQList = RFQModel::select("*")
        ->where('is_child','=', 0)
        ->get()
        ->sortByDesc("id");
        $productList = ProductModel::select("product_name","id")
        ->where("product_type", 'Service')
        ->get()
        ->sortByDesc("id");
        $users= app('App\Http\Models\TrackerModel')->getUsers();
        $contactType = app('App\Http\Models\EmployeeModel')->getLookup('lead_track_contact_type');
        
        // $query = DB::getQueryLog();
        //               $query = end($query);
        //               print_r($query);exit;
                $allRFQs =RFQModel::join('rfq_products', 'rfq_products.rfq_id', '=', 'rfq.id')
               ->get(['rfq_products.*', 'rfq.*'])
               ->sortByDesc("id");
               
        return view('showRFQ',compact('allRFQs','RFQList','users','contactType','productList')); 
    }
    /*
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RFQ  $RFQ
     * @return \Illuminate\Http\Response
     */
    public function editRFQ($id,RFQModel $RFQ)
    {
        DB::enableQueryLog();
        $de_id=base64_decode($id);
        $productList = ProductModel::select("product_name","id")
        ->where("product_type", 'Service')
        ->get()
        ->sortByDesc("id");
        $product = RFQModel::findOrFail($de_id);
        // $query = DB::getQueryLog();
        //               $query = end($query);
        //               print_r($query);
        //               exit;
        //  echo '<pre>';
        //             print_r($product);
        //             echo '</pre>'; exit;
        $RFQProducts =RFQProductsModel::join('product', 'rfq_products.product_id', '=', 'product.id')
        ->where('rfq_products.rfq_id','=', $de_id)
        ->get(['rfq_products.*', 'product.product_name']);
          
                    $preselectProducts='';
                    $product_idFirst=$RFQProducts[0]->product_id;
                    $quantityFirst=$RFQProducts[0]->quantity;
                    $unitsFirst=$RFQProducts[0]->units;
                    $selling_priceFirst=$RFQProducts[0]->selling_price;
                    $subtotalFirst=$RFQProducts[0]->subtotal;
                    $j=2;
                    $selected='selected';
                    $notselected='';
                    for ($i=1; $i<=count($RFQProducts)-1;$i++) { 
                        $pdt_id=$RFQProducts[$i]->product_id;
                   $preselectProducts.='
                   <tr id="rec-'.$j.'"><td>'.$j.'<input type="hidden" name="sno" id="sno" value="'.$j.'"></td><td><select class="form-control rfq_Product_name custom-select " id="product_name-'.$j.'" data-id="'.$j.'">
                                    <option value="">Select</option>';
                                    foreach($productList as $pt)
                                    {
                                        if($pt->id==$pdt_id)
                                        {
                                         $sel ='selected';
                                        }
                                        else
                                        {
                                        $sel ='';
                                        }
                                        $preselectProducts .= '<option value="' . $pt->id . '" '.$sel.' >' . $pt->product_name . '</option>';
                                    }
                                    $preselectProducts .= '</select>
                                <span class="wd-10p load-mul-product"></span>
                            </td>
                            <td><input type="text" class="form-control rfq_quantity" name="quantity"placeholder="Quantity" id="quantity-'.$j.'" maxlength="3" value="' . $RFQProducts[$i]->quantity . '"  data-id="'.$j.'" ></td>
                            <td><input type="text" class="form-control" name="units" id="units-'.$j.'" placeholder="Units" value="' . $RFQProducts[$i]->units . '"  readonly></td>
                            <td><input type="text" class="form-control hidetd" name="selling_price" id="selling_price-'.$j.'"
                                    placeholder="Price" value="' . $RFQProducts[$i]->selling_price . '" readonly>
                            </td>
                            <td><input type="text" class="form-control subtotal" name="subtotal" placeholder="Subtotal"
                                    id="subtotal-'.$j.'" value="' . $RFQProducts[$i]->subtotal . '"></td>
                            <td>
                                <a class="btn btn-primary btn-sm mb-2 mb-xl-0 add-record hidetd fa fa-plus" data-added="0"><i
                                 ></i></a>&nbsp;&nbsp;
                                <a class="btn btn-danger btn-sm mb-2 mb-xl-0 delete-record hidetd fa fa-trash" data-id="'.$j.'"><i
                                ></i></a>
                            </td></tr>';
                            $j++;
                    }
                   
        $rfq_discount = app('App\Http\Models\EmployeeModel')->getLookup('rfq_discount');
        $lead='';           
        return view('add-req', compact('lead','product','preselectProducts','RFQProducts','unitsFirst','selling_priceFirst','rfq_discount','subtotalFirst','quantityFirst','product_idFirst','productList'));
    }
    public function viewSingleRFQ($id,RFQModel $RFQ,RFQProductsModel $RFQProduct)
    {
        $de_id=base64_decode($id);
        $RFQList = RFQModel::findOrFail($de_id);
        if($RFQList->parent_id)
        {
        $RFQTracking=RFQModel::select('*')
        ->where('rfq.parent_id','=', $RFQList->parent_id)
        ->get(['rfq_products.*', 'product.product_name']);
        }
        $RFQProducts =RFQProductsModel::join('product', 'rfq_products.product_id', '=', 'product.id')
        ->where('rfq_products.rfq_id','=', $de_id)
        ->get(['rfq_products.*', 'product.product_name']);
        return response()->json(array('RFQProducts' => $RFQProducts,'RFQTracking'=>$RFQTracking,'RFQList' => $RFQList), 200);
    }
    public function editLeadRFQ($id,LeadModel $Lead)
    {
        $de_id=base64_decode($id);
        $RFQProducts='';$preselectProducts='';$product='';
        $lead = DB::select("select * from lead where is_active = true and id = " . $de_id);
        $productList = ProductModel::select("product_name","id")
        ->where("product_type", 'Service')
        ->get()
        ->sortByDesc("id");
        $rfq_discount = app('App\Http\Models\EmployeeModel')->getLookup('rfq_discount');
        
       return view('add-req', compact('lead','rfq_discount','product','RFQProducts','productList','preselectProducts'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RFQ  $RFQ
     * @return \Illuminate\Http\Response
     */
    public function destroyRFQ(Request $request)
    {   
        DB::enableQueryLog();
        $RFQ = RFQModel::findOrFail($_POST['data']['id']);
        $RFQ->delete();
        RFQProductsModel::where('rfq_products.rfq_id',$_POST['data']['id'])->delete();
           //$query = DB::getQueryLog();
                    //   $query = end($query);
                    //   print_r($query);
                    //   exit;
        $result=1;
        return response()->json(array('status' => $result), 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RFQ  $RFQ
     * @return \Illuminate\Http\Response
     */
    public function searchRFQ()
    {
        DB::enableQueryLog();
        $allRFQs = RFQModel::all()->sortByDesc("id");
        $allCategories = CategoryModel::all()->sortByDesc("id");
        $RFQ_type = app('App\Http\Models\EmployeeModel')->getLookup('RFQ_inventory_type');
        return view('searchRFQ',compact('allRFQs','allCategories','RFQ_type')); 
    }

    public function searchResults(Request $request)
    {
        DB::enableQueryLog();
        $RFQList = RFQModel::all()->sortByDesc("id");
        $input=$request->input(); 
        $searchFields = ['customer_name','contact_name','email','phone','searchProduct_name'];
        $allRFQs = DB::table('rfq')
                        ->where(function($query)
                        use ($input,$searchFields) {
                        $showAll = array_filter($_POST['data']);
                        if(empty($showAll))
                        {
                        $query->Where('rfq.is_active', '=', true);
                        }
                       else
                       {
                             $customer_name=$_POST['data']['customer_name'];
                             $contact_name=$_POST['data']['contact_name'];
                             $email=$_POST['data']['email'];
                             $phone=$_POST['data']['phone'];
                             $from=$_POST['data']['from'];
                             $to=$_POST['data']['to'];
                         if ($customer_name) {
                             $query->Where('customer_name', 'like', '%' . $customer_name . '%');
                         }
                         if ($contact_name) {
                             $query->Where('contact_name', 'like', '%' .$contact_name. '%');
                         }
                         if ($email) {
                             $query->Where('email', '=', '' . $email . '');
                         }
                         if ($phone) {
                             $query->Where('phone', '=', '' . $phone . '');
                         }
                         if ($from) {
                            $query->Where('updated_at', '>=', '' . $from . '');
                            $query->orWhere('updated_at', '<=', '' . $to . '');

                          // $query->whereBetween('created_date', [$from, $to]);
                         }
                         $query->Where('rfq.is_active', '=', true);

                        }
                          })
                          
                      ->get(['rfq.*'])
                      ->sortByDesc("rfq.id");
//                                       $query = DB::getQueryLog();
//                       $query = end($query);
//                       print_r($query);
// exit;
 return response()->json(array('allRFQs' => $allRFQs), 200);

    }
}