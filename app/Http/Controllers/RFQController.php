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
use PDF;

class RFQController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //To display product data in grid table - product code
    public function viewProductGridData($product_code, ProductModel $Product)
    {
        $de_product_code = base64_decode($product_code);
        $product = ProductModel::select('*')
            ->where('product.product_code', '=', $de_product_code)
            ->get()
            ->sortByDesc("id");
        return response()->json(array('allProducts' => $product), 200);
    }
    //Generate and Close Quotation Scenario - View Single RFQ
    public function quotationStatus(Request $request, RFQModel $RFQ)
    {
        DB::enableQueryLog();
        $param['status'] = $_POST['data']['status'];
        $de_id = base64_decode($_POST['data']['id']);
        RFQModel::whereId($de_id)->update($param);
        $query = DB::getQueryLog();
        $query = end($query);
        if ($_POST['data']['status'] == 'generateQuote') {
            $res = $this->viewSingleRFQ($_POST['data']['id']);
            $pdfRes = $res->original;
            // $data = [
            //     'title' => 'Product Information',
            //     'author' => "Meena"
            // ];

            // $pdf = PDF::loadView('generate-quote-file', $data);

            // return $pdf->download('test.pdf');
        } else {
            $pdfRes = '';
        }
        return response()->json(array('result' => $param, 'pdfRes' => $pdfRes), 200);
    }
    //To check data - qunatity and price
    public function compareStockQuantity($price, $product_code, ProductModel $Product)
    {
        DB::enableQueryLog();
        $product = ProductModel::select('*')
            ->where('product.actual_price', '=', $price)
            ->where('product.product_code', '=', $product_code)
            ->first();
        //Check Number of prices per product
        $productPrice = ProductModel::select('*')
            ->where('product.product_code', '=', $product_code)
            ->get()
            ->sortByDesc("id");

        $cntAP = count($productPrice);
        $chkStock = $product['quantity'];
        $pdt_id = $product['id'];
        return response()->json(array('compareQuantity' => $chkStock, 'product_id' => $pdt_id, 'cntAp' => $cntAP), 200);
    }
    //Add RFQ
    public function addRFQ(RFQModel $RFQ)
    {
        DB::enableQueryLog();
        $product = '';
        $RFQProducts = '';
        $preselectProducts = '';
        $lead = '';
        $productList = DB::table('product')->select(DB::raw('DISTINCT on(product_name)product_name,id,product_code'))->where('product_type', 'Service')->orderBy('product_name', 'desc')
            ->orderBy('id', 'desc')
            //->orderBy('product_code','desc')
            //->limit(10)
            ->get(['product_name', 'id', 'product_code']);
        //  $query = DB::getQueryLog();
        //               $query = end($query);
        //               print_r($query);exit;
        $rfq_discount = app('App\Http\Models\EmployeeModel')->getLookup('rfq_discount');
        return view('add-req', compact('product', 'lead', 'RFQProducts', 'preselectProducts', 'rfq_discount', 'productList'));
    }
    //Add Sales
    public function addSales(RFQModel $RFQ)
    {
        DB::enableQueryLog();
        $product = '';
        $RFQProducts = '';
        $preselectProducts = '';
        $lead = '';
        $productList = DB::table('product')->select(DB::raw('DISTINCT on(product_name)product_name,id,product_code'))->where('product_type', 'Service')->orderBy('product_name', 'desc')
            ->orderBy('id', 'desc')
            ->orderBy('product_code', 'desc')
            ->get(['product_name', 'id', 'product_code']);
        // $query = DB::getQueryLog();
        //               $query = end($query);
        //               print_r($query);exit;
        $rfq_discount = app('App\Http\Models\EmployeeModel')->getLookup('rfq_discount');

        return view('add-sales', compact('product', 'lead', 'RFQProducts', 'preselectProducts', 'rfq_discount', 'productList'));
    }
    //CREATE RFQ
    public function storeRFQ(Request $request, RFQModel $RFQ)
    {
        $pass = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 8);
        $param = array(
            'customer_name' => $_POST['data']['customer_name'],
            'contact_name' => $_POST['data']['contact_name'],
            'phone' => $_POST['data']['phone'],
            'email' => $_POST['data']['email'],
            'address' => $_POST['data']['address'],
            'description' => $_POST['data']['description'],
            'total_pdt_price' => $_POST['data']['grdtot'],
            'labourcharge' => $_POST['data']['labour_charge'],
            'transportcharge' => $_POST['data']['transport_charge'],
            'margin' => $_POST['data']['margin'],
            'proposed_value' => $_POST['data']['proposed_value'],
            'final_value' => $_POST['data']['final_value'],
            'discount_type' => $_POST['data']['discount_type'],
            'discount_value' => $_POST['data']['discount_value'],
            // 'amc'=>$_POST['data']['amc'],
            'is_active' => true
        );
        DB::enableQueryLog();
        //UPDATE PRODUCT AND RFQ  
        if ($_POST['data']['id'] != '') {
            $RFQ = RFQModel::findOrFail($_POST['data']['id']);
            $param['quote_id'] = $RFQ->quote_id;
            $param['modified_by'] = Session::get('user-id');
            $param['updated_at'] = date('Y-m-d H:i:s');
            RFQModel::create($param);
            $rfqID = DB::getPdo()->lastInsertId();
            for ($i = 0; $i < $_POST['data']['rowLen']; $i++) {
                $pdt = $_POST['data']['mul_pdt_name'][$i];
                $quantity = $_POST['data']['mul_quantity'][$i];
                $units = $_POST['data']['mul_units'][$i];
                $actual_price = $_POST['data']['mul_actual_price'][$i];
                $subtotal = $_POST['data']['mul_subtotal'][$i];
                $param_pdts = array(
                    'product_id' => $pdt,
                    'quantity' => $quantity,
                    'units' => $units,
                    'actual_price' => $actual_price,
                    'subtotal' => $subtotal,
                    'is_active' => true,
                    'rfq_id' => $rfqID,
                    'quote_id' => $RFQ->quote_id
                );
                DB::table("rfq_products")->insert($param_pdts);
                $result = 1;
            }
        } else {
            $isExist = RFQModel::select("*")
                ->where("email", $_POST['data']['email'])
                ->exists();
            if ($isExist == 1) {
                $result = 3;
            } else {
                $param['created_by'] = Session::get('user-id');
                $param['created_date'] = date('Y-m-d H:i:s');
                $param['quote_id'] = $pass;
                RFQModel::create($param);
                $rfqID = DB::getPdo()->lastInsertId();
                for ($i = 0; $i < $_POST['data']['rowLen']; $i++) {
                    $pdt = $_POST['data']['mul_pdt_name'][$i];
                    $quantity = $_POST['data']['mul_quantity'][$i];
                    $units = $_POST['data']['mul_units'][$i];
                    $actual_price = $_POST['data']['mul_actual_price'][$i];
                    $subtotal = $_POST['data']['mul_subtotal'][$i];
                    $param = array(
                        'product_id' => $pdt,
                        'quantity' => $quantity,
                        'units' => $units,
                        'actual_price' => $actual_price,
                        'subtotal' => $subtotal,
                        'is_active' => true,
                        'rfq_id' => $rfqID
                    );
                    DB::table("rfq_products")->insert($param);
                }
                //Lead Creation - Direct RFQ convert into Lead table
                $param = array(
                    'country' => 1,
                    'region' => 1,
                    'location' => 6,
                    'created_by' => Session::get('user-id'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'name' => $_POST['data']['customer_name'],
                    'contact_name' => $_POST['data']['contact_name'],
                    'phone' => $_POST['data']['phone'],
                    'email' => $_POST['data']['email'],
                    'address' => $_POST['data']['address'],
                    'description' => $_POST['data']['description'],
                    'status' => '0',
                    'is_active' => true
                );
                $lead_isExist = DB::select("select * from lead where email='" . $_POST['data']['email'] . "' AND phone='" . $_POST['data']['phone'] . "'");
                if (count($lead_isExist) == 0) {
                    DB::table("lead")->insert($param);
                    $leadID = DB::getPdo()->lastInsertId();
                } else {
                    $result = 3;
                }
                //lead and RFQ Mapping
                $param_mapping = array(
                    'created_by' => Session::get('user-id'),
                    'created_date' => date('Y-m-d H:i:s'),
                    'lead_id' => $leadID,
                    'rfq_id' => $rfqID,
                    'is_active' => true
                );
                LeadRFQMappingModel::create($param_mapping);
                $result = 1;
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
      //  $RFQList = RFQModel::all()->sortByDesc("id");
       $RFQList = DB::table('rfq')->select(DB::raw('DISTINCT on(quote_id)quote_id,max(customer_name)customer_name,max(id)id,max(contact_name)contact_name,max(email)email,max(final_value)final_value,max(last_tracked_date)last_tracked_date,max(created_at)created_at'))->groupBy('quote_id')->get();
        // $query = DB::getQueryLog();
        //                       $query = end($query);
        //                       print_r($query);exit;
        $users = app('App\Http\Models\TrackerModel')->getUsers();
        $contactType = app('App\Http\Models\EmployeeModel')->getLookup('lead_track_contact_type');
        $allRFQs = RFQModel::join('rfq_products', 'rfq_products.rfq_id', '=', 'rfq.id')
            ->get(['rfq_products.*', 'rfq.*'])
            ->sortByDesc("id");

        return view('showRFQ', compact('allRFQs', 'RFQList', 'users', 'contactType'));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RFQ  $RFQ
     * @return \Illuminate\Http\Response
     */
    public function showSales(Request $request)
    {
        DB::enableQueryLog();
        $SalesList = RFQModel::select("*")
            ->where('rfq.status', '=', 'generateQuote')
            ->get()
            ->sortByDesc("id");
        return view('showSales', compact('SalesList'));
    }
    /*
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RFQ  $RFQ
     * @return \Illuminate\Http\Response
     */
    public function editRFQ($id, RFQModel $RFQ)
    {
        DB::enableQueryLog();
        $de_id = base64_decode($id);
        //Drop down
        $productList = DB::table('product')->select(DB::raw('DISTINCT on(product_name)product_name,id,product_code,actual_price'))->where('product_type', 'Service')->orderBy('product_name', 'desc')
            ->orderBy('id', 'desc')
            ->orderBy('product_code', 'desc')
            ->orderBy('actual_price', 'desc')
            ->get(['product_name', 'id', 'product_code', 'actual_price']);
        //To get lead or RFQ information
        $product = RFQModel::findOrFail($de_id);
        //To get product grid data
        $RFQProducts = RFQProductsModel::join('product', 'rfq_products.product_id', '=', 'product.id')
            ->where('rfq_products.rfq_id', '=', $de_id)
            ->orwhere('rfq_products.rfq_id', '=', $product->parent_id)
            ->get(['rfq_products.*', 'product.*']);

        //   $query = DB::getQueryLog();
        //               $query = end($query);
        //               print_r($query);

        $preselectProducts = '';
        $product_id1First = $RFQProducts[0]->product_id;
        $product_idFirst = $RFQProducts[0]->product_code;
        $quantityFirst = $RFQProducts[0]->quantity;
        $unitsFirst = $RFQProducts[0]->units;
        $actual_priceFirst = $RFQProducts[0]->actual_price;
        $subtotalFirst = $RFQProducts[0]->subtotal;
        //Actual price and quantiy and code
        $productQuaFirst = ProductModel::select('*')
            ->where('product.actual_price', '=', $actual_priceFirst)
            ->where('product.product_code', '=', $product_idFirst)
            ->first();
        //Check Number of prices per product
        $productPriceFirst = ProductModel::select('*')
            ->where('product.product_code', '=', $product_idFirst)
            ->get()
            ->sortByDesc("id");
        $compareQuantityFirst = $quantityFirst;
        $cntPriceFirst = count($productPriceFirst);
        $j = 2;
        $selected = 'selected';
        $notselected = '';
        for ($i = 1; $i <= count($RFQProducts) - 1; $i++) {
            $pdt_id = $RFQProducts[$i]->product_code;
            $actual_price = $RFQProducts[$i]->actual_price;
            //Actual price and quantiy and code
            $productQua = ProductModel::select('*')
                ->where('product.actual_price', '=', $actual_price)
                ->where('product.product_code', '=', $pdt_id)
                ->first();
            //Check Number of prices per product
            $productPriceMultiple = ProductModel::select('*')
                ->where('product.product_code', '=', $pdt_id)
                ->get()
                ->sortByDesc("id");
            $cntAP = count($productPriceMultiple);
            $chkStock = $productQua['quantity'];

            $preselectProducts .= '
                   <tr id="rec-' . $j . '"><td>' . $j . '<input type="hidden" name="sno" id="sno" value="' . $j . '"></td><td><select class="form-control rfq_Product_name custom-select " id="product_name-' . $j . '" data-id="' . $j . '">
                                    <option value="">Select</option>';
            foreach ($productList as $pt) {
                if ($pt->product_code == $pdt_id) {
                    $sel = 'selected';
                } else {
                    $sel = '';
                }
                $preselectProducts .= '<option value="' . $pt->product_code . '" ' . $sel . ' >' . $pt->product_name . '</option>';
            }
            $preselectProducts .= '</select>
                                <span class="wd-10p load-mul-product"></span>
                                <input type="hidden" class="form-control" name="product_id-" id="product_id-' . $j . '" maxlength="3" value="' . $RFQProducts[$i]->id . '"  data-id="' . $j . '" >
                            </td>
                            <td><input type="text" class="form-control rfq_quantity" name="quantity"placeholder="Quantity" id="quantity-' . $j . '" maxlength="10" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="' . $RFQProducts[$i]->quantity . '"  data-id="' . $j . '" ></td>
                            <td><input type="text" class="form-control" name="units" id="units-' . $j . '" placeholder="Units" value="' . $RFQProducts[$i]->units . '"  readonly></td>
                            <td><select class="form-control custom-select chkQuantitybyPrice" id="actual_price-' . $j . '" data-id="' . $j . '" disabled>';
            $preselectProducts .= '<option value="' . $actual_price . '" ' . $sel . ' >' . $actual_price . '</option>';
            $preselectProducts .= '</select>
                            <input type="hidden" class="form-control" name="product_id-" id="product_id-' . $j . '"  value="' . $RFQProducts[$i]->id . '"  data-id="' . $j . '">
                                <input type="hidden" class="form-control" name="compareQuantity" id="compareQuantity-' . $j . '"  value="' . $chkStock . '"  data-id="' . $j . '">
                                <input type="hidden" class="form-control" name="cntPrice" id="cntPrice-' . $j . '"  value="' . $cntAP . '"  data-id="' . $j . '">
                            </td>
                            <td><input type="text" class="form-control subtotal" name="subtotal" placeholder="Subtotal"
                                    id="subtotal-' . $j . '" value="' . $RFQProducts[$i]->subtotal . '" readonly></td>
                            <td>
                                <a class="btn btn-primary btn-sm mb-2 mb-xl-0 add-record hidetd fa fa-plus" data-added="0"><i
                                 ></i></a>&nbsp;&nbsp;
                                <a class="btn btn-danger btn-sm mb-2 mb-xl-0 delete-record hidetd fa fa-trash" data-id="' . $j . '"><i
                                ></i></a>
                            </td></tr>';
            $j++;
        }

        $rfq_discount = app('App\Http\Models\EmployeeModel')->getLookup('rfq_discount');
        $lead = '';
        return view('add-req', compact('lead', 'product', 'preselectProducts', 'RFQProducts', 'unitsFirst', 'actual_priceFirst', 'product_id1First', 'compareQuantityFirst', 'cntPriceFirst', 'rfq_discount', 'subtotalFirst', 'quantityFirst', 'product_idFirst', 'productList'));
    }
    public function viewSingleRFQ($id)
    {
        $de_id = base64_decode($id);
        $RFQList = RFQModel::findOrFail($de_id);
        $RFQProducts = RFQProductsModel::join('product', 'rfq_products.product_id', '=', 'product.id')
            ->where('rfq_products.rfq_id', '=', $de_id)
            ->get(['rfq_products.*', 'product.product_name']);
            $RFQHistoryProducts = RFQProductsModel::join('product', 'rfq_products.product_id', '=', 'product.id')
            ->where('rfq_products.quote_id', '=', $RFQList->quote_id)
            ->get(['rfq_products.*', 'product.product_name']);
        return response()->json(array('RFQProducts' => $RFQProducts,'RFQHistoryProducts' => $RFQHistoryProducts, 'RFQList' => $RFQList), 200);
    }
    
    public function editLeadRFQ($id, LeadModel $Lead)
    {
        $de_id = base64_decode($id);
        $RFQProducts = '';
        $preselectProducts = '';
        $product = '';
        $lead = DB::select("select * from lead where is_active = true and id = " . $de_id);
        $productList = DB::table('product')->select(DB::raw('DISTINCT on(product_name)product_name,id,product_code'))->where('product_type', 'Service')->orderBy('product_name', 'desc')
            ->orderBy('id', 'desc')
            ->orderBy('product_code', 'desc')
            ->get(['product_name', 'id', 'product_code']);
        $rfq_discount = app('App\Http\Models\EmployeeModel')->getLookup('rfq_discount');

        return view('add-req', compact('lead', 'rfq_discount', 'product', 'RFQProducts', 'productList', 'preselectProducts'));
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
        RFQProductsModel::where('rfq_products.rfq_id', $_POST['data']['id'])->delete();
        //$query = DB::getQueryLog();
        //   $query = end($query);
        //   print_r($query);
        //   exit;
        $result = 1;
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
        return view('searchRFQ', compact('allRFQs', 'allCategories', 'RFQ_type'));
    }

    public function searchResults(Request $request)
    {
        DB::enableQueryLog();
        $RFQList = RFQModel::all()->sortByDesc("id");
        $input = $request->input();
        $searchFields = ['customer_name', 'contact_name', 'email', 'phone', 'searchProduct_name'];
        $allRFQs = DB::table('rfq')
            ->where(function ($query)
            use ($input, $searchFields) {
                $showAll = array_filter($_POST['data']);
                if (empty($showAll)) {
                    $query->Where('rfq.is_active', '=', true);
                } else {
                    $customer_name = $_POST['data']['customer_name'];
                    $contact_name = $_POST['data']['contact_name'];
                    $email = $_POST['data']['email'];
                    $phone = $_POST['data']['phone'];
                    $from = $_POST['data']['from'];
                    $to = $_POST['data']['to'];
                    if ($customer_name) {
                        $query->Where('customer_name', 'like', '%' . $customer_name . '%');
                    }
                    if ($contact_name) {
                        $query->Where('contact_name', 'like', '%' . $contact_name . '%');
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
