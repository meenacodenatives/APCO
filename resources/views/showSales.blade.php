@extends('layouts.master')
@section('css')
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/fileexport/buttons.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet" />
<!-- INTERNAL  DATE PICKER CSS-->
<link href="{{URL::asset('assets/css/pickadate.css')}}" rel="stylesheet">
<!-- INTERNAL SELECT2 CSS -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<!-- INTERNAL  MULTI SELECT CSS -->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/multipleselect/multiple-select.css')}}">
@endsection
@section('page-header')

<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">Sales</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/' . $page='dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sales</li>
        </ol>
    </div>
    <div class="ml-auto pageheader-btn">
        <a href="{{url('/' . $page='add-sales')}}" class="btn btn-secondary btn-icon text-white">
            <span>
                <i class="fe fe-plus"></i>
            </span> Add Sales
        </a>
    </div>
</div>
<!-- PAGE-HEADER END -->
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <!--<div class="card-header">
                <h3 class="card-title">Data Tables</h3>
            </div>-->
            <div class="card-body">
                <div class="table-responsive">
                    <table id="RFQDataTable" class="table table-striped table-bordered text-nowrap w-100">
                        <thead>
                                <tr>
                                    <th class="wd-25p">Business Name</th>
                                    <th class="wd-25p">Contact Name</th>
                                    <th class="wd-10p">Email</th>
                                    <th class="wd-25p">Proposed Value</th>
                                    <th class="wd-25p">Final Value</th>
                                    <th class="wd-25p">Last Track</th>
                                    <th class="wd-10p">Updated On</th>
                                    <th class="wd-10p">&nbsp;</th>
                                </tr>
                        </thead>
                        <tbody>
                            <?php if (count($SalesList) > 0): foreach ($SalesList as $pt): ?>
                                <tr>
                                    <td>{{$pt->customer_name}} </td>
                                    <td>{{$pt->contact_name}} </td>
                                    <td>{{$pt->email}}</td>
                                    <td>
                                        {{$pt->proposed_value}}
                                    </td>
                                    <td>
                                        {{$pt->final_value}}
                                    </td>

                                    @if($pt->last_tracked_date!=null)
                                    <td>{{date('M d, Y', strtotime($pt->last_tracked_date))}}</td>
                                    @else
                                    <td>{{$pt->last_tracked_date}}</td>
                                    @endif
                                    <td>{{date('M d, Y', strtotime($pt->updated_at))}}</td>
                                    <td>
                                        <a href="#" class="btn btn-secondary btn-sm mb-2 mb-xl-0 getRFQname"
                                            data-toggle="modal" id="viewSingleRFQ" data-target="#viewRFQ"
                                            data-id="<?= base64_encode($pt->id); ?>"
                                            data-RFQName="<?= $pt->customer_name ?>">
                                            <i class="fa fa-eye"></i></a>&nbsp;&nbsp;
                                        <a href="{{url('/' . $page='edit-RFQ')}}/<?= base64_encode($pt->id); ?>"
                                            class="ubtn<?= base64_encode($pt->id); ?> btn btn-primary btn-sm mb-2 mb-xl-0"
                                            data-toggle="tooltip" id="editSingleRFQ" data-original-title="Edit"><i
                                                class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                                        <a id="confirmRFQDelete" data-id="<?= $pt->id; ?>"
                                            class="ubtn<?= $pt->id; ?> btn btn-danger btn-sm mb-2 mb-xl-0"
                                            data-toggle="tooltip" data-original-title="Delete"><i
                                                class="fa fa-trash"></i></a>&nbsp;&nbsp;
                                        <span class="delrfq<?= $pt->id; ?>"></span>
                                    </td>
                                </tr>
                            <?php
                                endforeach;
                            else:
                                ?>

                            <tr>
                                <td colspan="6">No Sales Found!</td>
                            </tr>

                            <?php endif; ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- TABLE WRAPPER -->
        </div>
        <!-- SECTION WRAPPER -->
    </div>
</div>

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
<script src="{{URL::asset('assets/plugins/input-mask/jquery.maskedinput.js')}}"></script>
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