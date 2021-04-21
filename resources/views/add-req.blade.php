@extends('layouts.master')

<!-- INTERNAL  DATE PICKER CSS-->
<link href="{{URL::asset('assets/plugins/date-picker/spectrum.css')}}" rel="stylesheet" />

<link href="{{URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet" />
<!-- INTERNAL SELECT2 CSS -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@section('page-header')
<!-- PAGE-HEADER -->
<div class="page-header">
    <div>

        <h1 class="page-title"> @if($product!='') Edit @else Add @endif RFQ </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/' . $page='dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/' . $page='showRFQ')}}">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                @if($product!='') Edit @else Add @endif RFQ </li>
        </ol>

    </div>
    <div class="ml-auto pageheader-btn">
        <a href="{{url('/' . $page='showRFQ')}}" class="btn btn-cyan btn-icon text-white">
            <span>
                <i class="fe fe-corner-up-left"></i>
            </span> Back
        </a>
    </div>
</div>
<!-- PAGE-HEADER END -->
@endsection
@section('content')
<!-- ROW-1 OPEN -->
@csrf

<div class="row">

    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Basic Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Business Name</label>
                            <input type="text"
                                value="{{($product!='') ? $product->customer_name : (($lead != '') ? $lead[0]->name : '')}}"
                                name="customer_name" id="customer_name" class="form-control"
                                placeholder="Business Name">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Contact Name </label>
                            <input type="text"
                                value="{{($product!='') ? $product->contact_name : (($lead != '') ? $lead[0]->contact_name : '')}}"
                                name="contact_name" id="contact_name" class="form-control" placeholder="Contact Name">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="text"
                                value="{{($product!='') ? $product->email : (($lead != '') ? $lead[0]->email : '')}}"
                                name="email" id="email" class="form-control" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" placeholder="Phone" id="phone"
                                value="{{($product!='') ? $product->phone : (($lead != '') ? $lead[0]->phone : '')}}">
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" id="address" style="resize:none"
                                placeholder="Address">{{($product!='') ? $product->address : (($lead != '') ? $lead[0]->address : '')}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="description" style="resize:none"
                                placeholder="Description">{{($product!='') ? $product->description : (($lead != '') ? $lead[0]->description : '')}}</textarea>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Product Information</h3>
            </div>
            <div class="card-body">
                <div class="row">

                    <table class="table table-striped table-bordered text-nowrap w-100" id="tbl_pdts">
                        <thead>
                            <tr>
                                <th class="wd-10p">#</th>
                                <th class="wd-35p">Product Name
                                <input type="hidden" class="form-control" name="hid_product_code" id="hid_product_code" value="">
                                </th>
                                <th class="wd-25p">Quantity</th>
                                <th class="wd-25p">Units</th>
                                <th class="wd-25p">Price</th>
                                <th class="wd-25p">Subtotal</th>
                                <th class="wd-10p">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_pdts_body">
                            <tr id="rec-1">
                                <td>1
                                </td>
                                <td>
                                    <select class="form-control rfq_Product_name custom-select" id="product_name-1"
                                        data-id="">
                                        <option value="">Select</option>
                                        @foreach($productList as $pt)
                                        <option value="{{$pt->product_code}}" @if($RFQProducts!='' )
                                            {{ ( $pt->product_code ==$product_idFirst) ? 'selected' : '' }}@endif>
                                            {{$pt->product_name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="wd-10p load-mul-product1"></span>
                                   
                                </td>
                                <td>
                                <input type="text" class="form-control rfq_quantity" name="Quantity"
                                        placeholder="Quantity" id="quantity-1" maxlength="3"
                                        onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                        value="@if($RFQProducts!=''){{$quantityFirst}}@endif" data-id=""></td>
                               <td><input type="text" class="form-control hidetd1" name="units" placeholder="Units"
                                        id="units-1" value="@if($RFQProducts!=''){{$unitsFirst}}@endif" readonly>
                                </td>
                                <td>
                                    <select class="form-control custom-select chkQuantitybyPrice" id="actual_price-1" data-id=""
                                        style="width: 250px;"  @if($RFQProducts!='') disabled @else  @endif>
                                        @if($RFQProducts!='')
                                        <option value="{{$actual_priceFirst}}">
                                            {{$actual_priceFirst}}</option>
                                            @else
                                         @endif
                                    </select>
                                    <input type="hidden" class="form-control" name="product_id-1" id="product_id-1" value="@if($RFQProducts!=''){{$product_id1First}}@else @endif">
                                    <input type="hidden" class="form-control" name="compareQuantity" id="compareQuantity-1" value="@if($RFQProducts!=''){{$compareQuantityFirst}}@else @endif">
                                <input type="hidden" class="form-control" name="cntPrice" id="cntPrice-1" value="@if($RFQProducts!=''){{$cntPriceFirst}}@else @endif">
                                </td>
                                <td><input type="text" class="form-control subtotal" name="subtotal"
                                        placeholder="Subtotal" id="subtotal-1"
                                        value="@if($RFQProducts!=''){{$subtotalFirst }}@endif" readonly></td>
                                <td><a class="btn btn-primary btn-sm mb-2 mb-xl-0 add-record hidetd1" data-added="0"><i
                                            class="fa fa-plus"></i></a>&nbsp;&nbsp;
                                    <a class="btn btn-danger btn-sm mb-2 mb-xl-0 delete-record hidetd1" data-id="1"><i
                                            class="fa fa-trash"></i></a>

                                </td>
                            </tr>
                            <div id="editPreselectProducts">{!! $preselectProducts !!}</div>
                        </tbody>
                    </table>
                </div>
                <div style="display:none;">
                    <table id="pdt_table">
                        <tr id="" class="">
                            <td><span class="sn"></span></td>
                            <td>
                                <select class="form-control rfq_Product_name custom-select" id="product_name-"
                                    data-id="" style="width: 250px;">
                                    <option value="">Select</option>
                                    @foreach($productList as $pt)
                                    <option value="{{$pt->product_code}}">{{$pt->product_name}}</option>
                                    @endforeach
                                </select>
                                <span class="wd-10p load-mul-product"></span>
                                

                            </td>
                            <td><input type="text" data-id="" class="form-control rfq_quantity" name="quantity"
                                    placeholder="Quantity" id="quantity-" maxlength="3"
disabled onkeypress='return event.charCode >= 48 && event.charCode <= 57' value=""
                                     ></td>
                            <td><input type="text" class="form-control" name="units" id="units-" placeholder="Units"
                                    value="@if($product!=''){{ $product->units }} @endif" readonly></td>
                            <td>
                                <select class="form-control custom-select chkQuantitybyPrice" data-id=""  id="actual_price-" disabled name="actual_price" style="width: 250px;">
                                </select>
                                <input type="hidden" class="form-control" name="product_id-" id="product_id-" value="">
                                <input type="hidden" class="form-control" name="compareQuantity" id="compareQuantity-" value="">
                                <input type="hidden" class="form-control" name="cntPrice" id="cntPrice-" value="">
                            </td>
                            <td><input type="text" class="form-control subtotal" name="subtotal" placeholder="Subtotal"
                                    id="subtotal-" value="" data-id="" readonly>
                                    </td>
                            <td>
                                <a class="btn btn-primary btn-sm mb-2 mb-xl-0 add-record hidetd fa fa-plus" id="testbtn"
                                    data-added="0"><i></i></a>&nbsp;&nbsp;
                                <a class="btn btn-danger btn-sm mb-2 mb-xl-0 delete-record hidetd fa fa-trash"
                                    data-id=""><i></i></a>
                            </td>
                        </tr>
                    </table>
                </div>
                <table class="col-md-12 col-sm-12 w-40 pull-right">
                    <tbody>
                        <tr class="wd-25p pb-10 lightBlue text-capitalize hideTotPdt" style="display:none;">
                            <td class="wd-10p">Total Amount</td>
                            <td class="wd-25p hideTotPdt" style="display:none;"><span
                                    class="grdtot">@if($product!=''){{$product->total_pdt_price}}@endif</span></td>
                        </tr>
                        <tr>
                            <td class="wd-10p">Labour Charge</td>
                            <td class="wd-25p">
                                <input type="text" class="form-control proposed_val_change" name="labour_charge"
                                    placeholder="Labour Charge"
                                    onkeypress='return event.charCode >= 48 && event.charCode <= 57' id="labour_charge"
                                    value="@if($product!=''){{$product->labourcharge}}@endif">
                            </td>
                        </tr>
                        <tr>
                            <td>Transport Charge</td>
                            <td>
                                <input type="text" class="form-control proposed_val_change" name="transport_charge"
                                    placeholder="Transport Charge"
                                    onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                    id="transport_charge" value="@if($product!=''){{$product->transportcharge }}@endif">
                            </td>

                        </tr>
                        <tr>
                            <td>Margin</td>
                            <td><input type="text" maxlength="10" class="form-control proposed_val_change margin"
                                    name="margin" placeholder="Margin" id="margin"
                                    value="@if($product!=''){{$product->margin}}@endif">
                            </td>

                        </tr>
                        <tr class="wd-25p p-10 lightBlue text-capitalize hideProposalVal" style="display:none;">
                            <td class="wd-10p">Proposal Value</td>
                            <td class="wd-25p">
                                <span class="proposal_value">@if($product!=''){{$product->proposed_value}}@endif</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="wd-10p">Add Discount Type</td>
                            <td class="wd-25p"><select class="form-control custom-select final_val_change"
                                    name="discount_type" id="discount_type">
                                    <option value="">Select</option>
                                    @foreach ($rfq_discount as $dis)
                                    <option value="{{ $dis->code }}" @if($product!='' )@if($product->discount_type ==
                                        $dis->code) selected @endif @endif
                                        >{{ $dis->code }}
                                    </option>
                                    @endforeach;
                                </select></td>
                        </tr>
                        <tr>
                            <td class="wd-10p">Add Discount</td>
                            <td class="wd-25p">
                                <input type="text" disabled="disabled" class="form-control final_val_change" name="add_discount"
                                    placeholder="Discount" id="add_discount"
                                    value="@if($product!=''){{$product->discount_value}}@endif">
                            </td>
                        </tr>
                        <tr class="wd-25p p-10 lightBlue text-capitalize hideFinalVal" style="display:none;">
                            <td class="wd-10p">Final Value</td>
                            <td class="wd-25p hideFinalVal" style="display:none;"><span
                                    class="final_value">@if($product!=''){{$product->final_value}}@endif</span>
                            </td>
                        </tr>
                        <tr>
                            <td>AMC
                                <input type="checkbox" name="" id="recurring" value="">
                            </td>
                            <td class="wd-25p">
                                <input type="text" class="form-control" disabled="disabled" placeholder="AMC" id="amc"
                                    value="@if($product!=''){{$product->amc}}@endif">
                            </td>
                        </tr>
                    </tbody>
                </table>


            </div>
        </div>




        <div class="col-md-12 col-sm-12">
            <div class="pull-right  ebtn pb-5 pr-2">
                <a href="javascript:;" onclick="createRFQ()" class="btn btn-primary RFQSave">Save</a>
                <a href="{{url('/showRFQ')}}" class="btn btn-danger RFQSave">Cancel</a>
            </div>
            <span id="load-RFQ" style="padding-top:25px;" class="pull-right pr-2"></span>
        </div>
    </div>

    <input type="hidden" class="form-control" name="editRFQID" id="editRFQID"
        value="@if($product!=''){{ $product->id }}  @endif">

    <input type="hidden" class="form-control" name="lead_id" id="lead_id" value="@if($lead!=''){{$lead[0]->id}}@endif">
    <!-- ROW-6 CLOSED -->
    @endsection
    @section('js')
    <script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/select2.js')}}"></script>
    <!-- INTERNAL SELECT2 JS -->
    <script src="{{URL::asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/sweet-alert.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/date-picker/spectrum.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/input-mask/jquery.maskedinput.js')}}"></script>

    @endsection