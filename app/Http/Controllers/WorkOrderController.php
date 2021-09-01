<?php

namespace App\Http\Controllers;
use App\Http\Models\WorkOrderModel;
use App\Http\Models\RFQProductsModel;
use App\Http\Models\WorkOrderProductsModel;
use Illuminate\Http\Request;
use Session;
use DB;
use Illuminate\Support\Arr;
use PDF;

class WorkOrderController extends Controller
{
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RFQ  $RFQ
     * @return \Illuminate\Http\Response
     */
    public function showWorkOrder(Request $request)
    {
        DB::enableQueryLog();
        $users = app('App\Http\Models\TrackerModel')->getUsers();
        $contactType = app('App\Http\Models\EmployeeModel')->getLookup('lead_track_contact_type');
        $workOrderList = DB::table('work_orders')->select(DB::raw('work_orders.id as work_order_id,work_orders.final_value,work_orders.last_tracked_date,work_orders.created_at,customer.*'))
        ->join('customer', 'customer.id', '=', 'work_orders.customer_id')
            ->orderBy('work_orders.id', 'desc')
            ->get();
            // $query = DB::getQueryLog();
            //   $query = end($query);
            //    print_r($query);
            // exit;
      return view('showWorkOrder', compact('workOrderList','users', 'contactType'));
    }
    public function viewSingleWorkOrder($id)
    {
        DB::enableQueryLog();
        $de_id = base64_decode($id);
        //Single - Work Order Details
        $workOrder = DB::table('work_orders')->select('work_orders.*','work_orders.id as work_order_id','customer.*')
        ->join('customer', 'customer.id', '=', 'work_orders.customer_id')
        ->where('work_orders.id', '=', $de_id)->get();
        $WorkOrderProducts = WorkOrderProductsModel::join('product', 'work_order_products.product_id', '=', 'product.id')
            ->where('work_order_products.work_order_id', '=',  $workOrder[0]->work_order_id)
            ->get(['work_order_products.units','work_order_products.quantity', 
            'work_order_products.subtotal', 'work_order_products.price', 'product.id','product.product_name','product.product_code']);
            // $query = DB::getQueryLog();
            //   $query = end($query);
            //    print_r($query);
            // exit;
            $cntPdtIDs = count($WorkOrderProducts);
            $statusID=$workOrder[0]->status;
        $lookup_st = DB::select("select * from lookup where is_active = true and id = ' $statusID'");
        $work_order_no=$workOrder[0]->work_order_no;
        $work_order_id=$workOrder[0]->work_order_id;

        if($workOrder[0]->is_recurring > 0) 
        {
            $wo_order='Yes';
        }
        else
        {
            $wo_order='No';
        }
        $workorderDetails = '';
        $workorderProductDetails = '';
        $sno=1;
        //$workorderDetails .='<div class="row">';
        $workorderDetails .='<div class="col-md-4"><div class="form-group">
        <label class="form-label lightBlue text-capitalize">Customer Name</label>';
        $workorderDetails .= '<span">'. $workOrder[0]->customer_client_name .'</span></div>
        <div class="form-group">
        <label class="form-label lightBlue text-capitalize">Contact Name</label>';
        $workorderDetails .= '<span">'. $workOrder[0]->customer_contact_name .'</span></div>
        <div class="form-group">
        <label class="form-label lightBlue text-capitalize">Phone No</label>';
        $workorderDetails .= '<span">'. $workOrder[0]->customer_direct_no .'</span></div>
        <div class="form-group">
        <label class="form-label lightBlue text-capitalize">Address</label>';
        $workorderDetails .= '<span">'. $workOrder[0]->customer_address .'</span></div>
        <div class="form-group">
        <label class="form-label lightBlue text-capitalize">Work Order Date</label>';
        $workorderDetails .= '<span">'. date("M d Y", strtotime($workOrder[0]->work_order_date)) .'</span></div>';
        $workorderDetails .= '</div>';
        $workorderDetails .='<div class="col-md-4">
        <div class="form-group">
        <label class="form-label lightBlue text-capitalize">Final Value</label>';
        $workorderDetails .= '<span">Rs. '. $workOrder[0]->final_value .'</span></div>
        <div class="form-group">
        <label class="form-label lightBlue text-capitalize">AMC</label>';
        $workorderDetails .= '<span">'. $wo_order .'</span></div>
        <div class="form-group">
        <label class="form-label lightBlue text-capitalize">Status</label>';
        $workorderDetails .= '<span">'. $lookup_st[0]->code .'</span></div>
        <div class="form-group">
        <label class="form-label lightBlue text-capitalize">Last Tracked Comment</label>';
        $workorderDetails .= '<span">'. $workOrder[0]->last_tracked_comment .'</span></div>';
        $workorderDetails .= '</div>';
        $workorderDetails .='<div class="col-md-4"><div class="form-group">
        <label class="form-label lightBlue text-capitalize">Last Tracked Date</label>';
        $workorderDetails .= '<span">'. $workOrder[0]->last_tracked_date .'</span></div>';
        $workorderDetails .= '</div>';
        $workorderProductDetails .= '<table class="table table-striped table-bordered text-nowrap  ">';
            $workorderProductDetails .= '<thead><tr>';
            $workorderProductDetails .= '<th class="wd-20p lightBlue">S.No</th>';
            $workorderProductDetails .= '<th class="wd-20p lightBlue">Product Name</th>';
            $workorderProductDetails .= '<th class="lightBlue">Quantity</th>';
            $workorderProductDetails .= '<th class="lightBlue">Units</th>';
            $workorderProductDetails .= '<th class="lightBlue">Price</th>';
            $workorderProductDetails .= '<th class="lightBlue">SubTotal</th>';
            $workorderProductDetails .= '</tr></thead><tbody>';
            $pdtSno=1;
            for ($j = 0; $j < $cntPdtIDs; $j++) {
                $workorderProductDetails .= '<tr>';
                $workorderProductDetails .= '<td>' . $pdtSno . '</td>';
                $workorderProductDetails .= '<td>' . $WorkOrderProducts[$j]->product_name . '</td>';
                $workorderProductDetails .= '<td>' . $WorkOrderProducts[$j]->quantity . '</td>';
                $workorderProductDetails .= '<td>' . $WorkOrderProducts[$j]->units . '</td>';
                $workorderProductDetails .= '<td>Rs. ' . $WorkOrderProducts[$j]->price . '</td>';
                $workorderProductDetails .= '<td>Rs. ' . $WorkOrderProducts[$j]->subtotal . '</td>';
                $pdtSno++;
            }
            $workorderProductDetails.='<tr><td align="right" colspan="6" class="lightBlue">Total Product Price: Rs. ' . $workOrder[0]->total_pdt_price . '</td></tr>';
        
        //$workorderDetails .= '</div>';

        $sno++;
        return response()->json(array('workorderDetails' => $workorderDetails,'work_order_no'=>$work_order_no,'work_order_id'=>$work_order_id,'workorderProductDetails'=>$workorderProductDetails), 200);
    }
    // public function searchResults(Request $request)
    // {
    //     DB::enableQueryLog();
    //     $RFQList = RFQModel::all()->sortByDesc("id");
    //     $input = $request->input();
    //     $searchFields = ['customer_name', 'contact_name', 'email', 'phone', 'searchProduct_name'];
    //     $allRFQs = DB::table('rfq')
    //         ->where(function ($query)
    //         use ($input, $searchFields) {
    //             $showAll = array_filter($_POST['data']);
    //             if (empty($showAll)) {
    //                 $query->Where('rfq.is_active', '=', true);
    //             } else {
    //                 $customer_name = $_POST['data']['customer_name'];
    //                 $contact_name = $_POST['data']['contact_name'];
    //                 $email = $_POST['data']['email'];
    //                 $phone = $_POST['data']['phone'];
    //                 $from = $_POST['data']['from'];
    //                 $to = $_POST['data']['to'];
    //                 if ($customer_name) {
    //                     $query->Where('customer_name', 'like', '%' . $customer_name . '%');
    //                 }
    //                 if ($contact_name) {
    //                     $query->Where('contact_name', 'like', '%' . $contact_name . '%');
    //                 }
    //                 if ($email) {
    //                     $query->Where('email', '=', '' . $email . '');
    //                 }
    //                 if ($phone) {
    //                     $query->Where('phone', '=', '' . $phone . '');
    //                 }
    //                 if ($from) {
    //                     $query->Where('updated_at', '>=', '' . $from . '');
    //                     $query->orWhere('updated_at', '<=', '' . $to . '');

    //                     // $query->whereBetween('created_date', [$from, $to]);
    //                 }
    //                 $query->Where('rfq.is_active', '=', true);
    //             }
    //         })

    //         ->get(['rfq.*'])
    //         ->sortByDesc("rfq.id");
    //     //                                       $query = DB::getQueryLog();
    //     //                       $query = end($query);
    //     //                       print_r($query);
    //     // exit;
    //     return response()->json(array('allRFQs' => $allRFQs), 200);
    // }
}
