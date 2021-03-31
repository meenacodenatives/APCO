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
        <h1 class="page-title">Lead</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/' . $page='dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lead</li>
        </ol>
    </div>
    <div class="ml-auto pageheader-btn">
        <a href="{{url('/' . $page='add-lead')}}" class="btn btn-secondary btn-icon text-white">
            <span>
                <i class="fe fe-plus"></i>
            </span> Add Lead
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
                                <th class="wd-10p">Contact Person</th>
                                <th class="wd-25p">E-mail</th>
                                <th class="wd-10p">Phone</th>
                                <th class="wd-10p">Created Date</th>
                                <th class="wd-10p">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($data['lead']) > 0): foreach ($data['lead'] as $le): ?>
                            <tr>
                                <td><?= $le->name ?></td>
                                <td><?= $le->contact_name ?></td>
                                <td><?= $le->email ?></td>
                                <td><?= $le->phone ?></td>
                                <td>
                                    <?=  date('d-m-Y', strtotime($le->created_date)); ?>
                                </td>
                                <td>
                                    <a href="{{url('/' . $page='edit-lead')}}/<?= $le->id; ?>"
                                        class="ubtn<?= $le->id; ?> btn btn-primary btn-sm mb-2 mb-xl-0"
                                        data-toggle="tooltip" data-original-title="Edit"><i
                                            class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                                    <a id="confirmUserDelete" data-id="<?= $le->id; ?>"
                                        class="ubtn<?= $le->id; ?> btn btn-danger btn-sm mb-2 mb-xl-0"
                                        data-toggle="tooltip" data-original-title="Delete"><i
                                            class="fa fa-trash"></i></a>&nbsp;&nbsp;
                                    <span class="deluser<?= $le->id; ?>"></span>
                                </td>
                            </tr>
                            <?php
                                endforeach;
                            else:
                                ?>

                            <tr>
                                <td colspan="6">No Lead Found!</td>
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
@endsection