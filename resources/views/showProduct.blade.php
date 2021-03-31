@extends('layouts.master')
@section('css')
<!-- APCO CSS -->
<link href="{{URL::asset('assets/css/cn-style.css')}}" rel="stylesheet" />

<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet" />
<!-- INTERNAL SELECT2 CSS -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<!-- INTERNAL  DATE PICKER CSS-->
<link href="{{URL::asset('assets/plugins/date-picker/spectrum.css')}}" rel="stylesheet" />

@endsection

@section('page-header')
<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">Product</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/' . $page='dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Product</li>
        </ol>
    </div>
    <div class="ml-auto pageheader-btn">
        <a id="pdtSearch" class="btn btn-primary btn-icon text-white">

            <span>
                <i class="fe fe-search"></i>
            </span> Advanced search
        </a>
        <a href="{{url('/' . $page='add-product')}}" class="btn btn-secondary btn-icon text-white">

            <span>
                <i class="fe fe-plus"></i>
            </span> Add Product
        </a>

    </div>
</div>
<!-- PAGE-HEADER END -->
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div style="display:none" class="col-md-12 col-lg-12" id="searchForm">
            <form method="post" name="pdtSearch" action="">

                <div class="card">@csrf
                    <div class="card-body">
                    <h1 class="page-title pb-5" id="example-Modal3">Advanced Search</h1>

                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label text-left">Category</label>

                                    <select style="width:350px;" name="category" id="category"
                                        class="form-control custom-select">
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
                                    <select style="width:350px;" name="searchProduct_name" id="searchProduct_name"
                                        class="form-control">
                                        <option value="">Select</option>
                                        @foreach($productList as $pt)
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
                                    <input type="text" class="form-control expiry_date" name="expiry_date"
                                        id="expiry_date" placeholder="Expiry Date" value="">
                                </div>
                                <div class="form-group">
                                    <label class="form-label text-left">Actual Price</label>
                                    <input type="text" class="form-control" name="actual_price" id="actual_price"
                                        placeholder="Actual Price" value="">
                                </div>
                            </div>
                        </div>
                        <div class="span12 text-center load-search-product">
                         </div>
                        <div class="row col-xl-12  text-center form p-4">
                            <div class="col-7">
                                <div class="pull-right ebtn  pr-2">
                                    <button class="btn btn-primary searchpdt" onclick="searchProduct()"
                                        type="submit">Search</button>
                                    <button class="btn btn-secondary searchpdt" onclick="resetForm()"
                                        type="button">Reset</button>
                                       
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="span12 text-center load-search-product">
                        </div>
                        <table id="table-sortable" class="table table-striped table-bordered text-nowrap w-100">

                            <thead>

                                <tr>
                                    <th class="wd-25p">Category</th>
                                    <th class="wd-25p">Product Name</th>
                                    <th class="wd-10p">Product Code</th>
                                    <th class="wd-25p">Type</th>
                                    <th class="wd-25p">Quantity</th>
                                    <th class="wd-25p">Units</th>
                                    <th class="wd-10p">Created Date</th>
                                    <th class="wd-10p">&nbsp;</th>
                                </tr>

                            </thead>
                            <tbody id="showPdt" style="display:none;">

                            </tbody>
                            <tbody id="hidePdt">
                                @if($allProducts->count() > 0 )
                                @foreach($allProducts as $pt)
                                <tr>
                                    <td>{{$pt->name}} </td>
                                    <td>{{$pt->product_name}} </td>
                                    <td>{{$pt->product_code}}</td>
                                    <td>
                                        {{$pt->product_type}}
                                    </td>
                                    <td>
                                        {{$pt->quantity}}
                                    </td>
                                    <td>
                                        {{$pt->units}}
                                    </td>
                                    <td>{{date('M d, Y', strtotime($pt->created_at))}}</td>
                                    <td>
                                        <a href="#" class="btn btn-secondary btn-sm mb-2 mb-xl-0" data-toggle="modal"
                                            id="viewSingleProduct" data-target="#viewProduct" data-id="<?= $pt->id; ?>">
                                            <i class="fa fa-eye"></i></a>&nbsp;&nbsp;
                                        <a href="{{url('/' . $page='edit-product')}}/<?= base64_encode($pt->id); ?>"
                                            class="ubtn<?= base64_encode($pt->id); ?> btn btn-primary btn-sm mb-2 mb-xl-0"
                                            data-toggle="tooltip" data-original-title="Edit"><i
                                                class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                                        <a id="confirmPdtDelete" data-id="<?= $pt->id; ?>"
                                            class="ubtn<?= $pt->id; ?> btn btn-danger btn-sm mb-2 mb-xl-0"
                                            data-toggle="tooltip" data-original-title="Delete"><i
                                                class="fa fa-trash"></i></a>&nbsp;&nbsp;
                                        <span class="delpdt<?= $pt->id; ?>"></span>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td>No Records Found</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>


                    </div>
                </div>
                <!-- TABLE WRAPPER -->

            </div>
            <!-- SECTION WRAPPER -->
        </div>
    </div>
</div>
<!-- .modal -->
<div class="modal fade" id="viewProduct" tabindex="-1" role="dialog" aria-labelledby="myCategory" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title showTitle" id="example-Modal3"></h5>
                <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>


            </div>
            <div class="col-sm-2"> <span class="load-edit-product"></span>
            </div>

            <div class="hideForm card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label lightBlue text-capitalize">Category </label>
                            <span id="cat_id"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label lightBlue text-capitalize">Product Code</label>
                            <span id="productCode"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label lightBlue text-capitalize">Batch Number</label>
                            <span id="batchNumber"></span>

                        </div>
                        <div class="form-group">
                            <label class="form-label lightBlue text-capitalize">Actual Price</label>
                            <span id="actualPrice"></span>
                        </div>


                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label lightBlue text-capitalize">Product Name</label>
                            <span id="productName"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label lightBlue text-capitalize">Quantity</label>
                            <span id="quantity"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label lightBlue text-capitalize">Manufacture Date</label>
                            <span id="mfgDate"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label lightBlue text-capitalize">Selling Price</label>
                            <span id="sellingPrice"></span>
                        </div>
                    </div>
                    <div class="col-md-4">

                        <div class="form-group">
                            <label class="form-label lightBlue text-capitalize">Product Type</label>
                            <span id="productType"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label lightBlue text-capitalize">Units</label>
                            <span id="units"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label lightBlue text-capitalize">Expiry Date</label>
                            <span id="expiryDate"></span>
                        </div>

                        <div class="form-group">
                            <label class="form-label lightBlue text-capitalize">GST</label>
                            <span id="gst"></span>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- Category MODAL CLOSED -->
        <!-- ROW-1 CLOSED -->
        @endsection
        @section('js')
        <!-- INTERNAL CHARTJS CHART JS -->
        <script src="{{URL::asset('assets/plugins/datatable/jquery.dataTables.min.js')}}"></script>
        <script src="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{URL::asset('assets/plugins/datatable/datatable.js')}}"></script>
        <script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
        <!--INTERNAL  POPOVER JS -->
        <script src="{{URL::asset('assets/js/popover.js')}}"></script>

        <!-- INTERNAL SWEET-ALERT JS -->
        <script src="{{URL::asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>
        <script src="{{URL::asset('assets/js/sweet-alert.js')}}"></script>
        <script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
        <script src="{{URL::asset('assets/js/select2.js')}}"></script>
        <script src="{{URL::asset('assets/plugins/date-picker/spectrum.js')}}"></script>
        <script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>
        <script src="{{URL::asset('assets/plugins/input-mask/jquery.maskedinput.js')}}"></script>
        @endsection