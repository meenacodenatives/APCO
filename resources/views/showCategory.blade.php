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
        <h1 class="page-title">Category</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/' . $page='dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Category</li>
        </ol>
    </div>
    <div class="ml-auto pageheader-btn">
        <a href="#" class="btn btn-secondary btn-icon" data-toggle="modal" id="cat" data-target="#addCat">

            <span>
                <i class="fe fe-plus"></i>
            </span> Add Category
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

                    <table id="data-table3" class="table table-striped table-bordered text-nowrap w-100">

                        <thead>
                            <tr>
                                <th class="wd-25p">Category</th>
                                <th class="wd-10p">Code</th>
                                <th class="wd-25p">Description</th>
                                <th class="wd-10p">Created Date</th>
                                <th class="wd-10p">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($allCategories as $ct)
                        @if($ct->is_child!=1)
                            <tr style="color:blue !important">
                                <td>{{$ct->name}}  </td>
                                <td>{{$ct->code}}</td>
                                @if(strlen($ct->description)>25)
                                <td  data-container="body" data-toggle="popover" data-popover-color="default" data-placement="bottom" title="{{$ct->code}}" data-content="{{$ct->description}}">
                                {{\Illuminate\Support\Str::limit($ct->description,25)}}
                                </td>
                                @else
                                <td>
                                {{$ct->description}}
                                </td>
                                 @endif
                                 
                                <td>{{date('M d, Y', strtotime($ct->created_at))}}</td>
                                <td> <a id="confirmCatEdit" data-id="<?= base64_encode($ct->id); ?>"
                                        class="ubtn<?= base64_encode($ct->id); ?> btn btn-primary btn-sm mb-2 mb-xl-0"
                                        data-toggle="tooltip" data-original-title="Edit"><i
                                            class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                                    <a id="confirmCatDelete" data-id="<?= $ct->id; ?>"
                                        class="ubtn<?= $ct->id; ?> btn btn-danger btn-sm mb-2 mb-xl-0"
                                        data-toggle="tooltip" data-original-title="Delete"><i
                                            class="fa fa-trash"></i></a>&nbsp;&nbsp;
                                    <span class="delcat<?= $ct->id; ?>"></span>
                                </td>
                            </tr>
                       @endif
                       @if(count($ct->childs))
                       @include('subChild',['childs' => $ct->childs])
                       @endif
                        @endforeach
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
<div class="modal fade" id="addCat" tabindex="-1" role="dialog" aria-labelledby="myCategory" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title showTitle" id="example-Modal3"></h5>
                <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>


            </div>
            <div class="col-sm-2"> <span class="load-edit-category"></span>
            </div>

            <div class="hideForm">
                <div class="modal-body" style="height:410px; ">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Name
                                </label>
                                <input type="text" class="form-control" name="catName" id="catName" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-success">
                                <label class="form-label">Code</label>
                                <input type="text" class="form-control" name="catCode" id="catCode">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="catDesc" name="catDesc" rows="3"
                                style="resize:none"></textarea>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-success">
                                <label class="form-label">Parent Category</label>
                                <select name="pCategory" id="pCategory" class="form-control">
                                    <option value="">Select
                                    </option>
                                    <?php foreach ($allCategories as $us): ?>
                                    <option value="<?= $us->id?>"><?= $us->name?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 text-right p-3 pr-6">
                            <button type="button" class="btn btn-primary categorySave"
                                onclick="createCategory()">Save</button>
                            <input type="hidden" id="cat_id" value="">
                            <button type="button" class="btn btn-secondary categorySave closeModal"
                                data-dismiss="modal">
                                Close
                            </button>
                            <span id="load-category"></span>
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

@endsection