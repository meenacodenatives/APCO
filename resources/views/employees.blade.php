@extends('layouts.master')
@section('css')
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/fileexport/buttons.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet" />
@endsection
@section('page-header')



<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">Employees</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/' . $page='dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Employees</li>
        </ol>
    </div>
    <div class="ml-auto pageheader-btn">
        <a href="{{url('/' . $page='add-employee')}}" class="btn btn-secondary btn-icon text-white">
            <span>
                <i class="fe fe-plus"></i>
            </span> Add Employee
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
                    <table id="data-table1" class="table table-striped table-bordered text-nowrap w-100">
                        <thead>
                            <tr>
                                <th class="wd-25p">Name</th>
                                <th class="wd-10p">Category</th>
                                <th class="wd-25p">E-mail</th>
                                <th class="wd-10p">Phone</th>
                                <th class="wd-10p">Status</th>
                                <th class="wd-10p">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($data['employees']) > 0): foreach ($data['employees'] as $emp): ?>
                                    <tr>
                                        <td><?= $emp->firstname . ' ' . $emp->lastname ?></td>
                                        <td><?= $emp->category ?></td>
                                        <td><?= $emp->email ?></td>
                                        <td><?= $emp->phone ?></td>
                                        <td><?php if ($emp->status == 'Active'): ?>
                                                <a href="javascript:;" class="badge badge-success"><?= $emp->status ?></a>
                                            <?php elseif ($emp->status == 'Inactive'): ?>
                                                <a href="javascript:;" class="badge badge-warning"><?= $emp->status ?></a>
                                            <?php elseif ($emp->status == 'Blocked'): ?>
                                                <a href="javascript:;" class="badge badge-danger"><?= $emp->status ?></a>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="{{url('/' . $page='edit-employee')}}/<?= $emp->id; ?>" class="ubtn<?= $emp->id; ?> btn btn-primary btn-sm mb-2 mb-xl-0" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                                            <a id="empConfirmUserDelete" data-id="<?= $emp->id; ?>" class="ubtn<?= $emp->id; ?> btn btn-danger btn-sm mb-2 mb-xl-0" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;
                                            <span class="deluser<?= $emp->id; ?>"></span>
                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                            else:
                                ?>

                                <tr><td colspan="6">No Employee Found!</td></tr>

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
@endsection
