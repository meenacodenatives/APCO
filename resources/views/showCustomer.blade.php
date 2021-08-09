@extends('layouts.master')
@section('css')
<link href="{{URL::asset('assets/css/treeView.css')}}" rel="stylesheet" />

<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/fileexport/buttons.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet" />

@endsection

@section('page-header')
<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">Customer</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/' . $page='dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Customer</li>
        </ol>
    </div>
    <div class="ml-auto pageheader-btn">
    <a id="customerSearch" class="btn btn-primary btn-icon text-white">
            <span>
                <i class="fe fe-search"></i>
            </span> Advanced search
        </a>
        <a href="{{url('/' . $page='add-customer')}}" class="btn btn-secondary btn-icon text-white">
            <span>
                <i class="fe fe-plus"></i>
            </span> Add Customer
        </a>
    </div>
</div>
<!-- PAGE-HEADER END -->
@endsection
@section('content')
<div class="row">
<div style="display:none" class="col-md-12 col-lg-12" id="searchForm">
        <form method="post" name="pdtSearch" action="">

            <div class="card">@csrf
                <div class="card-body">
                    <h1 class="page-title pb-5" id="example-Modal3">Advanced Search</h1>

                    <div class="row">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label text-left">Business Name</label>
                                <input type="text" class="form-control" name="name" id="leadName" placeholder="Name"
                                    value="">

                            </div>
                            <div class="form-group">
                                <label class="form-label text-left">Contact Person</label>
                                <input type="text" class="form-control" name="leadcontactName" id="leadcontactName"
                                    placeholder="ContactPerson" value="">

                            </div>
                            <div class="form-group">
                                <label class="form-label text-left">Email</label>
                                <input type="text" class="form-control" name="leadEmail" id="leadEmail"
                                    placeholder="Email" value="">
                            </div>
                            <div class="form-group">
                                <label class="form-label text-left">Phone</label>
                                <input type="text" class="form-control" name="leadPhone" id="leadPhone"
                                    placeholder="Phone" value="">
                            </div>
                        </div>

                        <div class="col-sm-4">


                            <div class="form-group">
                                <label class="form-label text-left">Created Date - From</label>
                                <input type="text" class="form-control from" name="from" id="customerFrom" placeholder="From"
                                    value="">

                            </div>
                            <div class="form-group">
                                <label class="form-label text-left">Status</label>
                                <select style="width:350px;" value="" multiple=multiple name="leadStatus"
                                    id="customerStatus">
                                    <?php foreach ($status as $st): ?>
                                    <option value="<?= $st->code ?>"><?= $st->code ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>

                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="form-group ">
                                <label class="form-label text-left">Created Date - To</label>

                                <input type="text" class="form-control to" name="to" id="customerTo" placeholder="To" value="">


                            </div>
                        </div>
                    </div>
                    <div class="span12 text-center load-search-lead">
                    </div>
                    <div class="row col-xl-12  text-center form p-4">
                        <div class="col-7">
                            <div class="pull-right ebtn  pr-2">
                                <button class="btn btn-primary searchlead" onclick="searchLead()"
                                    type="submit">Search</button>
                                <button class="btn btn-secondary searchlead" onclick="customerresetForm()" type="button">Reset</button>

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

                    <table id="data-table3" class="table table-striped table-bordered text-nowrap w-100">

                        <thead>
                            <tr>
                                <th class="wd-25p">Customer</th>
                                <th class="wd-10p">Mobile No</th>
                                <th class="wd-10p">Choice</th>
                                <th class="wd-10p">Created Date</th>
                                <th class="wd-10p">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody id="hideLead">
                            @if(count($allCustomers) > 0 )
                            @foreach($allCustomers as $ct)
                            <tr style="color:blue !important">
                                <td>{{$ct->customer_client_name}} </td>
                                <td>{{$ct->customer_mob_no}}</td>
                                <td>@if($ct->is_product=='Yes') Product @else Service
                                    @endif
                                </td>
                                <td>{{date('M d, Y', strtotime($ct->created_at))}}</td>
                                <td>
                                    <a class="ubtn<?= base64_encode($ct->id); ?> btn btn-primary btn-sm mb-2 mb-xl-0" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-eye"></i></a>
                                    <a href="{{url('/' . $page='edit-customer')}}/<?= base64_encode($ct->id); ?>" data-id="<?= base64_encode($ct->id); ?>" class="ubtn<?= base64_encode($ct->id); ?> btn btn-primary btn-sm mb-2 mb-xl-0" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                                    <a id="customerConfirmUserDelete" data-id="<?= $ct->id; ?>" class="ubtn<?= $ct->id; ?> btn btn-danger btn-sm mb-2 mb-xl-0" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;
                                    <span class="delcustomer<?= $ct->id; ?>"></span>
                                </td>
                            </tr>

                            @endforeach
                            @else
                        <tr colspan="8">
                            <td>No Records Found</td>
                        </tr>
                        @endif
                        </tbody>
                        
                        <tbody id="showLead" style="display:none">
                        </tbody>
                    </table>


                </div>
            </div>
            <!-- TABLE WRAPPER -->
        </div>
        <!-- SECTION WRAPPER -->
    </div>
</div>
<!-- .modal -->

<!-- Customer MODAL CLOSED -->
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
@endsection