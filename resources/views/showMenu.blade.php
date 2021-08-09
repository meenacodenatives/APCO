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
                                <th class="wd-25p">Controller</th>
                                <th class="wd-10p">Created Date</th>
                                <th class="wd-10p">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($MenuList->count() > 0 )
                            @foreach($MenuList as $me)
                            @if($me->menu_parent==0)
                            <tr style="color:blue !important">
                                <td>{{$me->menu_name}}</td>
                                <td>
                                
                                    <a href="{{ env('MENU_PATH') }}{{$me->menu_link}}">{{$me->menu_name}}</a>
                                </td>
                                <td>{{$me->menu_controller}}</td>
                                <td>{{date('M d, Y', strtotime($me->created_at))}}</td>
                                <td> <a id="confirmMenuEdit" data-id="<?= base64_encode($me->id); ?>"
                                        class="ubtn<?= base64_encode($me->id); ?> btn btn-primary btn-sm mb-2 mb-xl-0"
                                        data-toggle="tooltip" data-original-title="Edit"><i
                                            class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                                    <a id="confirmMenuAssignUser" data-id="<?= base64_encode($me->id); ?>"
                                        class="ubtn<?= base64_encode($me->id); ?> btn btn-primary btn-sm mb-2 mb-xl-0"
                                        data-toggle="tooltip" data-original-title="Assign User"><i
                                            class="fa fa-plus"></i></a>&nbsp;&nbsp;
                                    <a id="confirmMenuDelete" data-id="<?= $me->id; ?>"
                                        class="ubtn<?= $me->id; ?> btn btn-danger btn-sm mb-2 mb-xl-0"
                                        data-toggle="tooltip" data-original-title="Delete"><i
                                            class="fa fa-trash"></i></a>&nbsp;&nbsp;
                                    <span class="delmenu<?= $me->id; ?>"></span>
                                </td>
                            </tr>
                            @endif
                            @if(count($me->childs))
                            @include('subMenu',['childs' => $me->childs])
                            @endif
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
                        <div class="col-md-6" >
                            <div class="form-group has-success" id="hideparentMenuList">
                                <label class="form-label">Parent Menu</label>
                                <select name="pMenu" id="pMenu" class="form-control test1" style="width: 360px;">
                                    <option value="">Select
                                    </option>
                                    <?php foreach ($Menus as $us): ?>
                                    <option value="<?= $us->id?>"><?= $us->menu_name?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group has-success" id="showEditParentList" style="display:none;">
                               
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-success">
                                <label class="form-label">Menu</label>
                                <input type="text" class="form-control" name="menuName" id="menuName">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-success">
                                <label class="form-label">Controller</label>
                                <input type="text" class="form-control" name="ControllerName" id="controllerName">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Link</label>
                            <input type="text" class="form-control" name="menuLink" id="menuLink">

                        </div>

                        <div class="col-12 text-right p-3 pr-6">
                            <button type="button" class="btn btn-primary menuSave" onclick="createMenu()">Save</button>
                            <input type="hidden" id="menu_id" value="">
                            <button type="button" class="btn btn-secondary menuSave closeModal" data-dismiss="modal">
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
<!-- showUsers-->
<div class="modal fade" id="showUsers" tabindex="-1" role="dialog" aria-labelledby="myMenu" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">Add/Edit Menu Group Users</h5>
                <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="col-sm-2"> <span class="load-edit-Menu"></span>
            </div>
            <div class="hideForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group has-success" id="hidechkBoxes">
                            <table class="table  text-nowrap w-70">
                                    @foreach($usersCategory as $key=>$us)
                                    <tr>
                                        <td>
                                            {{$us->category_name}}
                                        </td>
                                    </tr>
                                    <tr>
                                        @foreach(explode('|', $us->user_p_id) as $key1=>$infoID)
                                        <td class="border border-dark">
                                        <input type="checkbox" name="user_id" id="user_id" value="<?= $us->cat_id.
                                        '_'.$infoID ?>">
                                        @foreach(explode('|', $us->fullname) as $key=>$info)
                                        {{$key1}}{{$info}}{{$key}}

                                        @if($key1==$key)
                                         {{$key1}}{{$info}}{{$key}}
                                         @endif
                                         @endforeach
                                        </td>
                                        @endforeach
                                    </tr>
                                    @endforeach


                                </table>
                            </div>
                            <div class="form-group has-success" id="showchkBoxes" style="display:none;"></div>
                        </div>
                        <div class="col-12 text-right p-3 pr-6">
                            <button type="button" class="btn btn-primary menuUsersSave"
                                onclick="savemenuUsers()">Save</button>
                            <input type="hidden" id="menuID" value="">
                            <button type="button" class="btn btn-secondary menuUsersSave closeModal"
                                data-dismiss="modal">
                                Close
                            </button>
                            <span id="load-menuUsers"></span>
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
<!-- INTERNAL SELECT2 JS -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<!-- INTERNAL MULTI SELECT JS -->

<script src="{{URL::asset('assets/js/select2.js')}}"></script>
@endsection