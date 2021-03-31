@extends('layouts.master')
<!-- INTERNAL SELECT2 CSS -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<!-- INTERNAL  DATE PICKER CSS-->
<link href="{{URL::asset('assets/plugins/date-picker/spectrum.css')}}" rel="stylesheet" />
@section('page-header')
<!-- PAGE-HEADER -->
<div class="page-header">
    <div>

        <h1 class="page-title"> @if($product!='') Edit @else Add @endif Product </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/' . $page='dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/' . $page='showProduct')}}">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                @if($product!='') Edit @else Add @endif Product </li>
        </ol>

    </div>
    <div class="ml-auto pageheader-btn">
        <a href="{{url('/' . $page='showProduct')}}" class="btn btn-cyan btn-icon text-white">
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
<div class="row">
    <div class="col-md-12">
        <div class="card">@csrf

            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select name="category" id="category" class="form-control custom-select">
                                <option value="">Select</option>
                                @foreach($allCategories as $ct)
                                @if($ct->is_child!=1)
                                <option value="{{$ct->id}}" class="lightBlue"
                                @if($product!='' ) @if($product->category ==
                                $ct->id) selected @endif @endif
                                    >{{$ct->name}}</option>
                                @endif
                                @if(count($ct->childs))
                                @foreach($ct->childs as $child)
                                <option value="{{$child->id}}"@if($product!='' ) @if($product->category ==
                                $child->id) selected @endif @endif>{{$child->name}}
                                - - {{$ct->name}}</option>
                                @endforeach
                                @endif

                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Quantity</label>
                            <input type="text" value="@if($product!=''){{ $product->quantity}} @endif" name="quantity"
                                id="quantity" class="form-control" placeholder="Quantity">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Product Code / SKQ</label>
                            <input type="text" value="@if($product!=''){{ $product->product_code}} @endif"
                                name="product_code" id="product_code" class="form-control" placeholder="Product Code">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Actual Price</label>
                            <input type="text" name="actual_price" id="actual_price"
                                value="@if($product!=''){{ $product->actual_price}} @endif" class="form-control"
                                placeholder="Actual Price">
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="product_name" id="product_name"
                                placeholder="Product Name" value="@if($product!=''){{ $product->product_name}} @endif">
                        </div>
                        <div class="form-group m-0">
                            <label class="form-label">Units</label>
                            <select name="units" id="units" class="form-control custom-select">
                                <option value="">Select</option>
                                @foreach ($product_units as $units)
                                <option value="{{ $units->code }}" @if($product!='' ) @if($product->units ==
                                    $units->code) selected @endif @endif
                                    >{{ $units->code }}
                                </option>
                                @endforeach;
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Manufacture Date</label>
                            <input type="text" class="form-control mfg_date" name="mfg_date" id="mfg_date"
                                placeholder="Manufacture Date" value="@if($product!=''){{ $product->mfg_date }} @endif">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Selling Price</label>
                            <input type="text" class="form-control" name="selling_price" id="selling_price"
                                placeholder="Selling Price"
                                value="@if($product!=''){{ $product->selling_price }} @endif">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Type</label>
                            <select name="product_type" id="product_type" class="form-control custom-select">
                                <option value="">Select</option>
                                @foreach ($product_type as $type)
                                <option value="{{ $type->code }}" @if($product!='' ) @if($product->product_type ==
                                    $type->code) selected @endif @endif
                                    >{{ $type->code }}
                                </option>
                                @endforeach;
                            </select>

                        </div>
                        <div class="form-group">
                            <label class="form-label">Batch Number</label>
                            <input type="text" class="form-control" name="batch_number" id="batch_number"
                                placeholder="Batch Number" value="@if($product!=''){{ $product->batch_number }} @endif">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Expiry Date</label>
                            <input type="text" class="form-control expiry_date" name="expiry_date" id="expiry_date"
                                placeholder="Expiry Date" value="@if($product!=''){{ $product->expiry_date }} @endif">

                        </div>
                        <div class="form-group">
                            <label class="form-label">GST</label>
                            <input type="text" class="form-control" name="gst" placeholder="GST" id="gst"
                                value="@if($product!=''){{ $product->gst }} @endif">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="pull-right  ebtn  pr-2">
                            <a href="javascript:;" onclick="createProduct()" class="btn btn-primary productSave">Save</a>
                            <a href="{{url('/showProduct')}}" class="btn btn-danger productSave">Cancel</a>
                        </div>
                        <span id="load-product" style="padding-top:25px;" class="pull-right pr-2"></span>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" class="form-control" name="editPdtID" id="editPdtID"
    value="@if($product!=''){{ $product->id }} @endif">
<!-- ROW-6 CLOSED -->
@endsection
@section('js')

<!-- INTERNAL SELECT2 JS -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
<script src="{{URL::asset('assets/plugins/date-picker/spectrum.js')}}"></script>
<script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>
<script src="{{URL::asset('assets/plugins/input-mask/jquery.maskedinput.js')}}"></script>

@endsection