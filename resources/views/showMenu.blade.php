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
        <h1 class="page-title">Menu</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/' . $page='dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Menu</li>
        </ol>
    </div>
    <div class="ml-auto pageheader-btn">
        <a href="#" class="btn btn-secondary btn-icon" data-toggle="modal" id="menuPopup" data-target="#addMenu">

            <span>
                <i class="fe fe-plus"></i>
            </span> Add Menu
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
                                <th class="wd-25p">Link</th>
                                <th class="wd-10p">Created Date</th>
                                <th class="wd-10p">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if($MenuList->count() > 0 )

                        @foreach($MenuList as $me)
                            <tr>
                                <td>{{$me->menu_name}}</td>
                                <td>
                                {{$me->menu_link}}
                                </td>
                                <td>{{date('M d, Y', strtotime($me->created_at))}}</td>
                                <td> <a id="confirmMenuEdit" data-id="<?= base64_encode($me->id); ?>"
                                        class="ubtn<?= base64_encode($me->id); ?> btn btn-primary btn-sm mb-2 mb-xl-0"
                                        data-toggle="tooltip" data-original-title="Edit"><i
                                            class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                                    <a id="confirmMenuDelete" data-id="<?= $me->id; ?>"
                                        class="ubtn<?= $me->id; ?> btn btn-danger btn-sm mb-2 mb-xl-0"
                                        data-toggle="tooltip" data-original-title="Delete"><i
                                            class="fa fa-trash"></i></a>&nbsp;&nbsp;
                                    <span class="delmenu<?= $me->id; ?>"></span>
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
<div class="modal fade" id="addMenu" tabindex="-1" role="dialog" aria-labelledby="myMenu" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title showTitle" id="example-Modal3"></h5>
                <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>


            </div>
            <div class="col-sm-2"> <span class="load-edit-Menu"></span>
            </div>

            <div class="hideForm">
                <div class="modal-body" style="height:280px; ">
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group has-success">
                                <label class="form-label">Parent Menu</label>
                                <select name="pMenu" id="pMenu" class="form-control">
                                    <option value="">Select
                                    </option>
                                    <?php foreach ($Menus as $us): ?>
                                    <option value="<?= $us->id?>"><?= $us->menu_name?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-success">
                                <label class="form-label">Menu</label>
                                <input type="text" class="form-control" name="menuName" id="menuName">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Link</label>
                            <input type="text" class="form-control" name="menuLink" id="menuLink">

                        </div>
                        
                        <div class="col-12 text-right p-3 pr-6">
                            <button type="button" class="btn btn-primary menuSave"
                                onclick="createMenu()">Save</button>
                            <input type="hidden" id="menu_id" value="">
                            <button type="button" class="btn btn-secondary menuSave closeModal"
                                data-dismiss="modal">
                                Close
                            </button>
                            <span id="load-Menu"></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- Menu MODAL CLOSED -->
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