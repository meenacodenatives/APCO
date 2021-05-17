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
        <h1 class="page-title">Employees Group</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/' . $page='dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Menu</li>
        </ol>
    </div>
    <div class="ml-auto pageheader-btn">
        <a href="#" class="btn btn-secondary btn-icon" data-toggle="modal" id="empGrpPopup" data-target="#addempGrp">

            <span>
                <i class="fe fe-plus"></i>
            </span> Add Employees Group
        </a>
    </div>
</div>
<!-- PAGE-HEADER END -->
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">

                    <table id="commonDataTable" class="table table-striped table-bordered text-nowrap w-100">

                        <thead>
                            <tr>
                                <th class="wd-10p">Name</th>
                                <th class="wd-10p">Code</th>
                                <th class="wd-10p">Total Users</th>
                                <th class="wd-10p">Created Date</th>
                                <th class="wd-10p">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($employeesGrpList->count() > 0 )
                            @foreach($employeesGrpList as $key=>$me)
                            <tr>
                                <td>{{$me->group_name}}</td>
                                <td>{{$me->group_code}}</td>
                                <td>{{$me->count_row}}</td>
                                <td>{{date('M d, Y', strtotime($me->created_at))}}</td>
                                <td> <a id="confirmEmpGroupEdit" data-id="<?= base64_encode($me->id); ?>"
                                        class="ubtn<?= base64_encode($me->id); ?> btn btn-primary btn-sm mb-2 mb-xl-0"
                                        data-toggle="tooltip" data-original-title="Edit"><i
                                            class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                                            <a id="confirmEmpGroupAssignUser" data-id="<?= base64_encode($me->id); ?>"
                                        class="ubtn<?= base64_encode($me->id); ?> btn btn-primary btn-sm mb-2 mb-xl-0"
                                        data-toggle="tooltip" data-original-title="Assign User"><i
                                            class="fa fa-plus"></i></a>&nbsp;&nbsp;
                                    <a id="confirmEmpGroupDelete" data-id="<?= $me->id; ?>"
                                        class="ubtn<?= $me->id; ?> btn btn-danger btn-sm mb-2 mb-xl-0"
                                        data-toggle="tooltip" data-original-title="Delete"><i
                                            class="fa fa-trash"></i></a>&nbsp;&nbsp;
                                    <span class="delEmpGroup<?= $me->id; ?>"></span>
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
<!-- .modal -->
<div class="modal fade" id="addempGrp" tabindex="-1" role="dialog" aria-labelledby="myMenu" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title showTitle" id="example-Modal3"></h5>
                <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>


            </div>
            <div class="col-sm-2"> <span class="load-edit-EmpGroup"></span>
            </div>

            <div class="hideForm">
                <div class="modal-body" style="height:190px; ">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group has-success">
                                <label class="form-label">Group Name</label>
                                <input type="text" class="form-control" name="groupName" id="groupName">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Group Code</label>
                            <input type="text" class="form-control" name="groupCode" id="groupCode">

                        </div>

                        <div class="col-12 text-right p-3 pr-6">
                            <button type="button" class="btn btn-primary empGrpSave"
                                onclick="createempGrp()">Save</button>
                            <input type="hidden" id="emp_group_id" value="">
                            <button type="button" class="btn btn-secondary empGrpSave closeModal" data-dismiss="modal">
                                Close
                            </button>
                            <span id="load-empGrp"></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- showUsers-->
<div class="modal fade" id="showUsers" tabindex="-1" role="dialog" aria-labelledby="myMenu" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">Add/Edit Employee Group Users</h5>
                <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="col-sm-2"> <span class="load-edit-EmpGroup"></span>
            </div>
            <div class="hideForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-success" id="hidechkBoxes">
                            <table class="table  text-nowrap w-70">
                            <tr>
                                <?php $index = 0; foreach ($users as $key=>$us){ ?>
                                    <td class="border border-dark">
                                <input type="checkbox" name="user_id" id="user_id" value="<?= $us->id ?>">
                                <?= $us->firstname ?>
                                <?= $us->lastname ?>
                                <?php if($index>2)
                                {?>
                                </td></tr>
                                <?php $index++; } } ?>
                            </table></div>
                            <div class="form-group has-success" id="showchkBoxes" style="display:none;"></div>
                        </div>
                        <div class="col-12 text-right p-3 pr-6">
                            <button type="button" class="btn btn-primary empGrpUsersSave"
                                onclick="saveempGrpUsers()">Save</button>
                                <input type="hidden" id="grpID" value="">
                            <button type="button" class="btn btn-secondary empGrpUsersSave closeModal" data-dismiss="modal">
                                Close
                            </button>
                            <span id="load-empGrpUsers"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Employee Group MODAL CLOSED -->
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