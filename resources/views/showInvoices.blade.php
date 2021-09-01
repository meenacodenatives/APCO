@extends('layouts.master')
@section('css')
<!-- APCO CSS -->
<link href="{{URL::asset('assets/css/cn-style.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/css/pickadate.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet" />

@endsection

@section('page-header')
<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">Invoices</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/' . $page='dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Invoices</li>
        </ol>
    </div>
    <div class="ml-auto pageheader-btn">
        <!-- <a id="rfqSearch" class="btn btn-primary btn-icon text-white">

            <span>
                <i class="fe fe-search"></i>
            </span> Advanced search
        </a> -->
        <!-- <a href="{{url('/' . $page='add-RFQ')}}" class="btn btn-secondary btn-icon text-white">

            <span>
                <i class="fe fe-plus"></i>
            </span> Add RFQ
        </a> -->
        <a href="{{url('/' . $page='showWorkOrder')}}" class="btn btn-cyan btn-icon text-white">
            <span>
                <i class="fe fe-corner-up-left"></i>
            </span> Back
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
                                    <label class="form-label text-left">Business Name</label>
                                    <input type="text" class="form-control customer_name" name="customer_name" id="customer_name" placeholder="Business Name" value="">
                                </div>
                                <div class="form-group">
                                    <label class="form-label text-left">Contact Name</label>
                                    <input type="text" class="form-control contact_name" name="contact_name" id="contact_name" placeholder="Contact Name" value="">
                                </div>
                                <div class="form-group">
                                    <label class="form-label text-left">Email</label>
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="">
                                </div>
                            </div>
                            <div class="col-sm-4">


                                <div class="form-group">
                                    <label class="form-label text-left">Updated Date - From</label>
                                    <input type="text" class="form-control from" name="from" id="from" placeholder="From" value="">

                                </div>
                                <div class="form-group">
                                    <label class="form-label text-left">Phone</label>
                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" value="">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group ">
                                    <label class="form-label text-left">Updated Date - To</label>
                                    <input type="text" class="form-control to" name="to" id="to" placeholder="To" value="">
                                </div>
                            </div>
                        </div>
                        <div class="span12 text-center load-search-RFQs">
                        </div>
                        <div class="row col-xl-12  text-center form p-4">
                            <div class="col-7">
                                <div class="pull-right ebtn  pr-2">
                                    <button class="btn btn-primary searchRFQs" onclick="searchRFQ()" type="submit">Search</button>
                                    <button class="btn btn-secondary searchRFQs" onclick="RFQresetForm()" type="button">Reset</button>

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
                        <div class="span12 text-center load-search-RFQs">
                        </div>
                        <table id="RFQDataTable" class="table table-striped table-bordered text-nowrap w-100">

                            <thead>

                                <tr>
                                    <th class="wd-25p">Business Name</th>
                                    <th class="wd-25p">Contact Name</th>
                                    <th class="wd-10p">Email</th>
                                    <th class="wd-25p">Invoice No</th>
                                    <th class="wd-25p">Invoice Date</th>
                                    <th class="wd-25p">Amount</th>
                                    <th class="wd-25p">Order Date</th>
                                    <th class="wd-25p">Payment Mode</th>
                                    <th class="wd-10p">Created On</th>
                                    <th class="wd-10p">&nbsp;</th>
                                </tr>

                            </thead>

                            <tbody id="hideRFQs">
                                @if(count($allInvoices) > 0)
                                @foreach($allInvoices as $pt)
                                <tr>
                                    <td> {{$pt->customer_client_name}}</td>
                                    <td> {{$pt->customer_contact_name}} </td>
                                    <td> {{$pt->customer_email_primary}}</td>
                                    <td>
                                    {{$pt->invoice_no}}
                                    </td>
                                    <td>{{date('M d, Y', strtotime($pt->invoice_date))}}</td>
                                    <td>
                                    {{$pt->amount}}
                                    </td>
                                    <td>{{date('M d, Y', strtotime($pt->order_dated))}}</td>
                                    <td>{{$pt->payment_mode}}</td>

                                    <td>{{date('M d, Y', strtotime($pt->created_at))}}</td>

                                    <td>
                                        <a href="#" class="btn btn-secondary btn-sm mb-2 mb-xl-0" data-toggle="modal" id="viewSingleInvoice" data-target="#viewInvoice" data-id="<?= base64_encode($pt->invoice_id); ?>">
                                            <i class="fa fa-eye"></i></a>&nbsp;&nbsp;
                                         

                                        <a id="confirmInvDelete" data-id="<?= $pt->invoice_id; ?>" class="ubtn<?= $pt->invoice_id; ?> btn btn-danger btn-sm mb-2 mb-xl-0" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;
                                        <span class="delInv<?= $pt->invoice_id; ?>"></span>
                                        
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr colspan="8">
                                    <td>No Records Found</td>
                                </tr>
                                @endif
                            </tbody>
                            <tbody id="showRFQs" style="display:none">

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

</div>
<!-- .modal -->
<div class="modal" id="viewInvoice">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 70%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">Invoice - <span class="invoiceNo lightBlue"></span></h5>
                <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                

            </div>
            <div class="card">

                <div class="card-body p-6">
                    <div class="panel panel-primary">
                        <div class="tab_wrapper first_tab tab-style3 " id="tabs">
                            <ul class="tab_list">
                                <li class="active">View</li>
                               
                            </ul>
                            <div class="content_wrapper">
                                <!-- 1 st tab -->
                                <div class="tab_content active">
                                    <div class="container">
                                        <div class="span12 text-center load-view-singleInvoice">
                                        </div>
                                        <div class="hideForm card-body" style="width: 950px;">

                                            <div class="row viewInvoiceData  w-100">
                                            </div>
                                            <div class="row viewInvoiceProductDetails  w-100">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                
                                

                            </div>
                        </div>


                    </div>
                </div>
            </div>
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
<script src="{{URL::asset('assets/plugins/date-picker/spectrum.js')}}"></script>
<script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>
<script src="{{URL::asset('assets/js/picker.js')}}"></script>
<script src="{{URL::asset('assets/js/picker.date.js')}}"></script>
<script src="{{URL::asset('assets/js/picker.time.js')}}"></script>
<!-- INTERNAL SELECT2 JS -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<!-- INTERNAL MULTI SELECT JS -->
<script src="{{URL::asset('assets/plugins/multipleselect/multiple-select.js')}}"></script>
<script src="{{URL::asset('assets/plugins/multipleselect/multi-select.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
@endsection