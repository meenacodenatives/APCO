<?php

namespace App\Http\Controllers;

use App\Http\Models\InvoicesModel;
use App\Http\Models\WorkOrderModel;
use App\Http\Models\InvoiceItemsModel;
use Illuminate\Http\Request;
use Session;
use DB;
use Illuminate\Support\Arr;
use PDF;

class InvoicesController extends Controller
{

    public function createInvoice($id)
    {
        DB::enableQueryLog();
        $product = '';
        $de_id = base64_decode($id);
        $commonStr = substr(str_shuffle("0123456789"), 0, 3);
        $invoiceNo = 'IN_' . date('dmY') . '' . $commonStr;
        $currentDate = date('d-m-Y H:i:s');

        $location = app('App\Http\Controllers\EmployeeController')->getLocation();
        //Single - Work Order Details
        $workOrder = DB::table('work_orders')->select('work_orders.*', 'customer.*')
            ->join('customer', 'customer.id', '=', 'work_orders.customer_id')
            ->where('work_orders.id', '=', $de_id)->get();
        //  $query = DB::getQueryLog();
        //       $query = end($query);
        //        print_r($query);
        //     exit;
        //print_r($workOrder); exit;
        $address = $workOrder[0]->customer_address;
        $description = $workOrder[0]->description;
        $work_order_no = $workOrder[0]->work_order_no;
        $work_order_date = $workOrder[0]->work_order_date;
        $invoiceProductDetails = '';
        $WorkOrderProducts = WorkOrderModel::join('product', 'work_orders.product_id', '=', 'product.id')
            ->where('work_orders.rfq_id', '=',  $workOrder[0]->rfq_id)
            ->get(['work_orders.units', 'work_orders.quantity', 'product.id', 'product.product_name', 'product.product_code']);
        $cntPdtIDs = count($WorkOrderProducts);
        $invoiceProductDetails .= '<table class="table table-striped table-bordered text-nowrap  ">';
        $invoiceProductDetails .= '<thead><tr>';
        $invoiceProductDetails .= '<th class="wd-20p lightBlue">S.No</th>';
        $invoiceProductDetails .= '<th class="wd-20p lightBlue">Product Name</th>';
        $invoiceProductDetails .= '<th class="lightBlue">Quantity</th>';
        $invoiceProductDetails .= '<th class="lightBlue">Units</th>';
        $invoiceProductDetails .= '<th class="lightBlue">Price</th>';
        $invoiceProductDetails .= '<th class="lightBlue">Subtotal</th>';
        $invoiceProductDetails .= '</tr></thead><tbody>';
        $pdtSno = 1;
        for ($j = 0; $j < $cntPdtIDs; $j++) {
            $invoiceProductDetails .= '<tr>';
            $invoiceProductDetails .= '<td>' . $pdtSno . '</td>';
            $invoiceProductDetails .= '<td>' . $WorkOrderProducts[$j]->product_name . '</td>';
            $invoiceProductDetails .= '<td>' . $WorkOrderProducts[$j]->quantity . '</td>';
            $invoiceProductDetails .= '<td>' . $WorkOrderProducts[$j]->units . '</td>';
            $invoiceProductDetails .= '<td> Rs. ' . 330.0 . '</td>';
            $invoiceProductDetails .= '<td> Rs. ' . 990.0 . '</td>';
            $pdtSno++;
        }
        $invoiceProductDetails .= '<tr><td align="right" colspan="6" class="lightBlue">Total Product Price:Rs. ' . 1980 . '</td></tr>';
        return view('create-invoice', compact('location', 'work_order_no', 'work_order_date', 'currentDate', 'invoiceNo', 'address', 'description', 'product', 'invoiceProductDetails'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RFQ  $RFQ
     * @return \Illuminate\Http\Response
     */
    public function destroyInvoice(Request $request)
    {
        DB::enableQueryLog();
        InvoicesModel::where('invoices.id', $_POST['data']['inv_id'])->delete();
        // InvoicesModel::where('invoices_items.invoice_id', $_POST['data']['id'])->delete();
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
    public function showInvoices(Request $request)
    {
        DB::enableQueryLog();
        //  $allInvoices = InvoicesModel::all()->sortByDesc("id");
        $allInvoices = DB::table('invoices')->select('invoices.*', 'invoices.id as invoice_id', 'customer.*')
            ->join('customer', 'customer.id', '=', 'invoices.customer_id')
            //->where('work_orders.id', '=', $de_id)
            ->get();
        // $query = DB::getQueryLog();
        //   $query = end($query);
        //    print_r($query);
        // exit;
        return view('showInvoices', compact('allInvoices'));
    }

    public function viewSingleInvoice($id)
    {
        DB::enableQueryLog();
        $de_id = base64_decode($id);
        //Single - Invoice Details
        $invoice = DB::table('invoices')->select('invoices.*', 'invoices.id as invoice_id','customer.*')
            ->join('customer', 'customer.id', '=', 'invoices.customer_id')
            ->where('invoices.id', '=', $de_id)->get();
        
        // 'work_orders.work_order_date','work_orders.final_value', $invoiceProducts = InvoicesModel::join('work_orders', 'work_orders.id', '=', 'invoices.work_order_id')
        //     ->join('product', 'product.id', '=', 'work_orders.product_id')
        //     ->where('invoices.id', '=',  $invoice[0]->invoice_id)
        //     ->get(['work_orders.units', 'work_orders.quantity', 'product.id', 'product.product_name', 'product.product_code']);
       
        $invoiceProducts =InvoiceItemsModel::where('invoices_items.invoice_id', $de_id)->get();
        
        $cntPdtIDs = count($invoiceProducts);
        
        $invoice_no = $invoice[0]->invoice_no;
        $invoice_id = $invoice[0]->id;

       
        $invoiceDetails = '';
        $invoiceProductDetails = '';
        $sno = 1;
        //$invoiceDetails .='<div class="row">';
        $invoiceDetails .= '<div class="col-md-4"><div class="form-group">
        <label class="form-label lightBlue text-capitalize">Customer Name</label>';
        $invoiceDetails .= '<span">' . $invoice[0]->customer_client_name . '</span></div>
        <div class="form-group">
        <label class="form-label lightBlue text-capitalize">Contact Name</label>';
        $invoiceDetails .= '<span">' . $invoice[0]->customer_contact_name . '</span></div>
        <div class="form-group">
        <label class="form-label lightBlue text-capitalize">Phone No</label>';
        $invoiceDetails .= '<span">' . $invoice[0]->customer_direct_no . '</span></div>
        <div class="form-group">
        <label class="form-label lightBlue text-capitalize">Address</label>';
        $invoiceDetails .= '<span">' . $invoice[0]->customer_address . '</span></div>
       ';
        $invoiceDetails .= '</div>';
        
        $invoiceDetails .= '</div>';
        $invoiceProductDetails .= '<table class="table table-striped table-bordered text-nowrap  ">';
        $invoiceProductDetails .= '<thead><tr>';
        $invoiceProductDetails .= '<th class="wd-20p lightBlue">S.No</th>';
        $invoiceProductDetails .= '<th class="wd-20p lightBlue">Product Name</th>';
        $invoiceProductDetails .= '<th class="lightBlue">Quantity</th>';
        $invoiceProductDetails .= '<th class="lightBlue">Units</th>';
        $invoiceProductDetails .= '</tr></thead><tbody>';
        $pdtSno = 1;
        for ($j = 0; $j < $cntPdtIDs; $j++) {
            $invoiceProductDetails .= '<tr>';
            $invoiceProductDetails .= '<td>' . $pdtSno . '</td>';
            $invoiceProductDetails .= '<td>' . $invoiceProducts[$j]->product_name . '</td>';
            $invoiceProductDetails .= '<td>' . $invoiceProducts[$j]->quantity . '</td>';
            $invoiceProductDetails .= '<td>' . $invoiceProducts[$j]->units . '</td>';
            $pdtSno++;
        }
        $invoiceProductDetails .= '<tr><td align="right" colspan="6" class="lightBlue">Total Product Price: ' . $invoice[0]->total_pdt_price . '</td></tr>';

        //$invoiceDetails .= '</div>';

        $sno++;
        return response()->json(array('invoiceDetails' => $invoiceDetails, 'invoice_no' => $invoice_no, 'invoice_id' => $invoice_id, 'invoiceProductDetails' => $invoiceProductDetails), 200);
    }
}
