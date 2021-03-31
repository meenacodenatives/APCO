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
                            <label class="form-label">Business Name </label>
                            <input type="text" value="@if($product!=''){{ $product->customer_name}} @else @if($lead!='') {{$lead[0]->name}} @endif @endif" name="customer_name"
                                id="customer_name" class="form-control" placeholder="Business Name">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Contact Name  </label>
                            <input type="text" value="@if($product!=''){{ $product->contact_name}} @else @if($lead!=''){{$lead[0]->contact_name}} @endif @endif"
                                name="contact_name" id="contact_name" class="form-control" placeholder="Contact Name">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="text" value="@if($product!=''){{ $product->email}} @else @if($lead!=''){{$lead[0]->email}} @endif @endif" name="email"
                                id="email" class="form-control" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" placeholder="Phone" id="phone"
                                value="@if($product!=''){{ $product->phone }} @else @if($lead!=''){{$lead[0]->phone}} @endif @endif">
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="form-label">Address</label>
                            <textarea class="form-control" id="address" style="resize:none"
                                placeholder="Address">@if($product!=''){{ $product->address }}@else @if($lead!='') {{$lead[0]->address}} @endif @endif</textarea>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="description" style="resize:none"
                                placeholder="Description">@if($product!=''){{ $product->description }} @else @if($lead!='') {{$lead[0]->description}} @endif @endif</textarea>
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
                                        <option value="{{$pt->id}}" @if($RFQProducts!='') {{ ( $pt->id ==$product_idFirst) ? 'selected' : '' }}@endif>{{$pt->product_name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="wd-10p load-mul-product1"></span>
                                </td>
                                <td><input type="text" class="form-control rfq_quantity" name="Quantity" placeholder="Quantity" id="quantity-1" maxlength="3"onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                        value="@if($RFQProducts!=''){{ $quantityFirst }} @endif" data-id=""></td>
                                <td><input type="text" class="form-control hidetd1" name="units" placeholder="Units"
                                        id="units-1" value="@if($RFQProducts!=''){{ $quantityFirst }} @endif" readonly></td>
                                <td><input type="text" class="form-control hidetd1" name="selling_price" placeholder="Price" id="selling_price-1"
                                        value="@if($RFQProducts!=''){{ $quantityFirst }} @endif" readonly></td>
                                <td><input type="text" class="form-control subtotal" name="subtotal" placeholder="Subtotal" id="subtotal-1" value="@if($RFQProducts!=''){{ $subtotalFirst }} @endif" readonly></td>
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
                <div  style="display:none;">
                    <table id="pdt_table">
                        <tr id="">
                            <td><span class="sn"></span></td>
                            <td><select class="form-control rfq_Product_name custom-select" id="product_name-"
                                    data-id="">
                                    <option value="">Select</option>
                                    @foreach($productList as $pt)
                                    <option value="{{$pt->id}}">{{$pt->product_name}}</option>
                                    @endforeach
                                    
                                </select>
                                <span class="wd-10p load-mul-product"></span>
                            </td>
                            <td><input type="text" class="form-control rfq_quantity" name="quantity"
                                    placeholder="Quantity" id="quantity-" maxlength="3"
                                onkeypress='return event.charCode >= 48 && event.charCode <= 57'
                                    value="" data-id="" ></td>
                            <td><input type="text" class="form-control" name="units" id="units-" placeholder="Units"
                                    value="@if($product!=''){{ $product->units }} @endif" readonly></td>
                            <td><input type="text" class="form-control hidetd" name="selling_price" id="selling_price-"
                                    placeholder="Price" value="@if($product!=''){{ $product->selling_price }} @endif" readonly>
                            </td>
                            <td><input type="text" class="form-control subtotal" name="subtotal" placeholder="Subtotal"
                                    id="subtotal-" value=""></td>
                            <td>
                                <a class="btn btn-primary btn-sm mb-2 mb-xl-0 add-record hidetd" data-added="0"><i
                                        class="fa fa-plus"></i></a>&nbsp;&nbsp;
                                <a class="btn btn-danger btn-sm mb-2 mb-xl-0 delete-record hidetd" data-id=""><i
                                        class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    </table>
                </div>

                <table class="table table-striped table-bordered text-nowrap w-60 pull-right">
                    <thead>
                        <tr>
                            <th class="wd-35p">Labour Charge
                            </th>
                            <th class="wd-25p">Transport Charge</th>
                            <th class="wd-25p">Margin</th>
                            <th class="wd-25p lightBlue text-capitalize hideTotPdt" style="display:none;">Total Amount</th>
                            <th class="wd-25p lightBlue hideProposalVal" style="display:none;">Proposal value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <td>
                            <input type="text" class="form-control" name="labour_charge" placeholder="Labour Charge"
                                onkeypress='return event.charCode >= 48 && event.charCode <= 57'  id="labour_charge" 
                                value="@if($product!=''){{ $product->labourcharge }} @endif">
                            </td>
                            <td><input type="text" class="form-control" name="transport_charge" placeholder="Transport Charge"
                            onkeypress='return event.charCode >= 48 && event.charCode <= 57'    id="transport_charge" value="@if($product!=''){{ $product->transportcharge }} @endif"></td>
                            <td><input type="text" maxlength="10" class="form-control margin" name="margin" placeholder="Margin" id="margin"
                                    value="@if($product!=''){{ $product->margin }} @endif" ></td>
                            <td class="pt-10 hideTotPdt" style="display:none;"><span class="grdtot">@if($product!=''){{ $product->total_pdt_price }} @endif</span></td>
                            <td class="pt-10 hideProposalVal" style="display:none;"><span class="proposal_value">@if($product!=''){{ $product->proposed_value }} @endif</span>
                            </td>

                        </tr>
                    </tbody>
                </table>
                <table class="table table-striped table-bordered text-nowrap w-60 pull-right">
                    <thead>
                        <tr>
                            <th class="wd-25p">Add Discount Type</th>
                            <th class="wd-25p">Add Value</th>
                            <th class="wd-25p lightBlue hideFinalVal" style="display:none;">Final value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <td><select class="form-control custom-select" name="discount_type" id="discount_type">
                            <option value="">Select</option>
                            @foreach ($rfq_discount as $dis)
                                <option value="{{ $dis->code }}" @if($product!='' ) @if($product->discount_type ==
                                    $dis->code) selected @endif @endif
                                    >{{ $dis->code }}
                                </option>
                                @endforeach;
                            </select></td>
                            <td class="pt-10"><input type="text" class="form-control" name="add_discount" placeholder="Discount" id="add_discount"
                             value="@if($product!=''){{ $product->discount_value }} @endif"></td>
                            <td class="pt-10 hideFinalVal" style="display:none;"><span class="final_value">@if($product!=''){{ $product->final_value }} @endif</span>
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
        <input type="text" class="form-control" name="lead_id" id="lead_id"
        value="@if($lead!='') {{$lead[0]->id}}  @endif">
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