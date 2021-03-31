@extends('layouts.master')
<!-- INTERNAL SELECT2 CSS -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<!-- INTERNAL  DATE PICKER CSS-->
<link href="{{URL::asset('assets/plugins/date-picker/spectrum.css')}}" rel="stylesheet" />
<!-- INTERNAL SELECT2 CSS -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />

@section('page-header')
<!-- PAGE-HEADER -->
<div class="page-header">
    <div>

        <h1 class="page-title">Search Product</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/' . $page='dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/' . $page='showProduct')}}">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                Search Product </li>
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
    <form method="post" action="{{ route('showProduct') }}">

        <div class="card">@csrf
            <div class="card-body">

                <div class="row col-xl-12 form p-4">
                
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="form-label text-left">Category</label>

                            <select name="category" id="category" class="form-control custom-select">
                                <option value="">Select</option>
                                @foreach($allCategories as $ct)
                                @if($ct->is_child!=1)
                                <option value="{{$ct->id}}">{{$ct->name}}</option>
                                @endif
                                @if(count($ct->childs))
                                @foreach($ct->childs as $child)
                                <option value="{{$child->id}}">{{$child->name}}
                                    - - {{$ct->name}}</option>
                                @endforeach
                                @endif

                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label text-left">Product Name</label>
                            <select name="product_name" id="product_name" class="form-control">
                            <option value="">Select</option>
                                @foreach($allProducts as $pt)
                                <option value="{{$pt->product_name}}">{{$pt->product_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">

                            <label class="form-label text-left">Product Type</label>
                            <select name="product_type" id="product_type" class="form-control custom-select">
                                <option value="">Select</option>
                                @foreach ($product_type as $type)
                                <option value="{{ $type->code }}">{{ $type->code }}
                                </option>
                                @endforeach;
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="form-label text-left">Manufacture Date</label>
                            <input type="text" class="form-control mfg_date" name="mfg_date" id="mfg_date"
                                placeholder="Manufacture Date" value="">
                        </div>
                        <div class="form-group">
                            <label class="form-label text-left">Expiry Date</label>
                            <input type="text" class="form-control expiry_date" name="expiry_date" id="expiry_date"
                                placeholder="Expiry Date" value="">
                        </div>
                        <div class="form-group">
                            <label class="form-label text-left">Actual Price</label>
                            <input type="text" class="form-control" name="actual_price" id="actual_price"
                                placeholder="Actual Price" value="">
                        </div>
                    </div>
                </div>
                <div class="row col-xl-12  text-center form p-4">

                    <div class="col-7">
                        <div class="pull-right ebtn  pr-2">
 
                                <button class="btn btn-primary productSave" type="submit">Search</button>

                            <a href="{{url('/showProduct')}}" class="btn btn-danger productSave">Cancel</a>
                        </div>
                        <span id="load-product" style="padding-top:25px;" class="pull-right pr-2"></span>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

<!-- ROW-6 CLOSED -->
@endsection
@section('js')

<!-- INTERNAL SELECT2 JS -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
<script src="{{URL::asset('assets/plugins/date-picker/spectrum.js')}}"></script>
<script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>
<script src="{{URL::asset('assets/plugins/input-mask/jquery.maskedinput.js')}}"></script>
<!-- INTERNAL SELECT2 JS -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>

<script src="{{URL::asset('assets/js/select2.js')}}"></script>

@endsection