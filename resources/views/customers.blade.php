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
        <h1 class="page-title">Customer</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/' . $page='dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Customer</li>
        </ol>
    </div>
    <div class="ml-auto pageheader-btn">
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
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <!--<div class="card-header">
                <h3 class="card-title">Data Tables</h3>
            </div>-->
            <div class="card-body">
                <div class="table-responsive">
                    <table id="data-table2" class="table table-striped table-bordered text-nowrap w-100">
                        <thead>
                            <tr>
                                <th class="wd-25p">Name</th>
                                <th class="wd-10p">Title</th>
                                <th class="wd-25p">E-mail</th>
                                <th class="wd-10p">Phone</th>
                                <th class="wd-10p">Status</th>
                                <th class="wd-10p">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($customer) > 0): foreach ($customer as $cu): ?>
                            <tr>
                                <td><?= $cu->cnct_name ?></td>

                                <td><?= $cu->cnct_title ?></td>
                                <td><?= $cu->cnct_email_prmy ?></td>
                                <td><?= $cu->cnct_mob_no ?></td>
                                <td><?php if ($cu->cnct_status == 1): ?>
                                                <a href="javascript:;" class="badge badge-success">Active</a>
                                            <?php elseif ($cu->cnct_status == 0): ?>
                                                <a href="javascript:;" class="badge badge-warning">Inactive</a>
                                            <?php endif; ?>
                                        </td>
                                <td>
                                    <a href="{{url('/' . $page='edit-customer')}}/<?= $cu->id; ?>"
                                        class="ubtn<?= $cu->id; ?> btn btn-primary btn-sm mb-2 mb-xl-0"
                                        data-toggle="tooltip" data-original-title="Edit"><i
                                            class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                                    <a id="customerConfirmUserDelete" data-id="<?= $cu->id; ?>"
                                        class="ubtn<?= $cu->id; ?> btn btn-danger btn-sm mb-2 mb-xl-0"
                                        data-toggle="tooltip" data-original-title="Delete"><i
                                            class="fa fa-trash"></i></a>&nbsp;&nbsp;
                                    <span class="delcustomer<?= $cu->id; ?>"></span>
                                </td>
                            </tr>
                            <?php
                                endforeach;
                            else:
                                ?>

                            <tr>
                                <td colspan="6">No Customer Found!</td>
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