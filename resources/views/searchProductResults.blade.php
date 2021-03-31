@extends('layouts.master')
<!-- INTERNAL SELECT2 CSS -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<!-- INTERNAL  DATE PICKER CSS-->
<link href="{{URL::asset('assets/plugins/date-picker/spectrum.css')}}" rel="stylesheet" />
<!-- INTERNAL SELECT2 CSS -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<!-- INTERNAL PRISM CSS -->
<link href="{{URL::asset('assets/plugins/prism/prism.css')}}" rel="stylesheet">
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
        <a href="{{url('/' . $page='searchProduct')}}" class="btn btn-cyan btn-icon text-white">
            <span>
                <i class="fe fe-corner-up-left"></i>
            </span> Back
        </a>
    </div>
</div>
<!-- PAGE-HEADER END -->
@endsection
@section('content')
<!-- ROW OPEN -->
<div class="row">
    <div class="col-sm-12 col-md-12" >
        <div class="card custom-card">
            <div class="card-body pb-0">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" data-live-search="true" aria-label="Search" placeholder="Searching.....">
                    <span class="input-group-append">
                        <button class="btn ripple btn-primary" type="button">Search</button>
                    </span>
                </div>

            </div>
             <div class="card-body p-3">
                <p class="text-muted mb-0 pl-3">About {{$productResults->count()}} results </p>
            </div> 
        </div>
        @if($productResults->count() > 0 )
        @foreach($productResults as $pt)
        <div  class="card custom-card">
            <div class="card-body">
                <div class="mb-2 h4 text-dark">
                    {{$pt->name}}
                </div>
                <h6>{{$pt->product_name}} - {{$pt->product_type}}</h6>
                <div class="row">
                    <div class="col-sm-4" >{{$pt->product_code}}</div>
                    <div class="col-sm-4 mb-0 text-muted" >{{$pt->quantity}}
                    </div>
                    <div class="col-sm-4">{{$pt->units}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4" >{{$pt->batch_number}}</div>
                    <div class="col-sm-4 mb-0 text-muted" >{{$pt->mfg_date}}
                    </div>
                    <div class="col-sm-4">{{$pt->expiry_date}}</div>
                </div>
                <div class="row">
                    <div class="col-sm-4" >{{$pt->actual_price}}</div>
                    <div class="col-sm-4 mb-0 text-muted" >{{$pt->selling_price}}
                    </div>
                    <div class="col-sm-4">{{$pt->gst}}</div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
        <div class="text-center">
            <div class="mb-5">
                <ul class="pagination justify-content-center">
                {!! $productResults->links() !!}
                    
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- ROW CLOSE -->
@endsection
@section('js')
<!-- INTERNAL  CLIPBOARD JS -->
<script src="{{URL::asset('assets/plugins/clipboard/clipboard.min.js')}}"></script>
        <script src="{{URL::asset('assets/plugins/clipboard/clipboard.js')}}"></script>

        <!-- INTERNALPRISM JS -->
        <script src="{{URL::asset('assets/plugins/prism/prism.js')}}"></script>
@endsection