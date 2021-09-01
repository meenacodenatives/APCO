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
        <h1 class="page-title">Work Order</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/' . $page='dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Work Order</li>
        </ol>
    </div>
    <div class="ml-auto pageheader-btn">
        <!-- <a id="WOSearch" class="btn btn-primary btn-icon text-white">

            <span>
                <i class="fe fe-search"></i>
            </span> Advanced search
        </a> -->
        <!-- <a href="{{url('/' . $page='add-WO')}}" class="btn btn-secondary btn-icon text-white">

            <span>
                <i class="fe fe-plus"></i>
            </span> Add WO
        </a> -->

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
                        <div class="span12 text-center load-search-WOs">
                        </div>
                        <div class="row col-xl-12  text-center form p-4">
                            <div class="col-7">
                                <div class="pull-right ebtn  pr-2">
                                    <button class="btn btn-primary searchWOs" onclick="searchWO()" type="submit">Search</button>
                                    <button class="btn btn-secondary searchWOs" onclick="WOresetForm()" type="button">Reset</button>

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
                        <div class="span12 text-center load-search-WOs">
                        </div>
                        <table id="commonDataTable" class="table table-striped table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="wd-25p">Business Name</th>
                                    <th class="wd-25p">Contact Name</th>
                                    <th class="wd-10p">Email</th>
                                    <th class="wd-25p">Final Value</th>
                                    <th class="wd-25p">Last Track</th>
                                    <th class="wd-10p">Updated On</th>
                                    <th class="wd-10p">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(count($workOrderList) > 0)
                            @foreach($workOrderList as $wo)
                            <tr>
                                    <td>{{$wo->customer_client_name}}</td>
                                    <td>{{$wo->customer_contact_name}}</td>
                                    <td>{{$wo->customer_email_primary}}</td>
                                    <td>
                                    Rs. {{$wo->final_value}}
                                    </td>
                                    @if($wo->last_tracked_date!='')
                                    <td>{{date('M d, Y', strtotime($wo->last_tracked_date))}}</td>
                                    @else
                                    <td>{{$wo->last_tracked_date}}</td>
                                    @endif
                                    <td>{{date('M d, Y', strtotime($wo->created_at))}}
                                    </td>
                                    <td>
                                    <a href="#" class="btn btn-secondary btn-sm mb-2 mb-xl-0 workOrderTracker" data-toggle="modal" id="viewSingleWorkOrder" data-target="#viewWorkOrder" 
                                   data-clientName="<?= $wo->customer_client_name ?>"data-id="<?= base64_encode($wo->work_order_id); ?>">
                                            <i class="fa fa-eye"></i></a>&nbsp;&nbsp;

                                        <a href="{{url('/' . $page='create-Invoice')}}/<?= base64_encode($wo->work_order_id); ?>" class="ubtn<?= base64_encode($wo->work_order_id); ?> btn btn-primary btn-sm mb-2 mb-xl-0" data-toggle="tooltip" id="createInvoice" data-original-title="Create an invoice"><i class="fa fa-plus"></i></a>&nbsp;&nbsp;
                                    </td>
                            </tr>
                                @endforeach
                                @else
                                <tr colspan="8">
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
</div>
<!-- .modal -->
<div class="modal" id="viewWorkOrder">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 70%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">Work Order Tracker - <span class="workOrderNo lightBlue"></span></h5>
                <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <input type="hidden" name="trac_WO_id" id="trac_WO_id">
                <input type="hidden" name="scheduler_WO_name" id="scheduler_WO_name">
                <input type="hidden" id="schedular_id" value="">
                <input type="hidden" id="s_type" value="Work Order">
                <input type="hidden" id="type_id" value="">

            </div>
            <div class="card">

                <div class="card-body p-6">
                    <div class="panel panel-primary">
                        <div class="tab_wrapper first_tab tab-style3 " id="tabs">
                            <ul class="tab_list">
                                <li class="active">View</li>
                                <li>Update Tracker</li>
                                <li>Scheduler</li>
                                <li>Invoices</li>
                            </ul>
                            <div class="content_wrapper">
                                <!-- 1 st tab -->
                                <div class="tab_content active">
                                    <div class="container">
                                        <div class="span12 text-center load-view-singleWorkOrder">
                                        </div>
                                        <div class="hideForm card-body" style="width: 950px;">

                                            <div class="row viewworkOrderData  w-100">
                                            </div>
                                            <div class="row viewworkorderProductDetails  w-100">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!-- 2 nd tab -->
                                <div class="tab_content">
                                    <form>
                                        <div class="container">
                                            <!-- Row -->
                                            <div class="row tracForm" style="width: 950px;">
                                                <div class="col-xs-9 col-md-7">
                                                    <div class="form-group">
                                                        <label class="form-label">Comment</label>
                                                        <textarea class="form-control" value="" name="comment" id="comment" placeholder="Comment" style="width:380px;height:160px; resize:none"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label class="form-label">Contact Mode</label>
                                                        <select name="contactType" id="contact_type" class="form-control custom-select">
                                                            <option value="">Select</option>
                                                            <?php foreach ($contactType as $ct) : ?>
                                                                <option value="<?= $ct->code ?>"><?= $ct->meaning ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Notify To</label>
                                                        <select name="notify_users" multiple="multiple" id="notify_users">
                                                            <?php foreach ($users as $us) : ?>
                                                                <option value="<?= $us->id ?>"><?= $us->firstname ?>
                                                                    <?= $us->lastname ?> </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-xs-9 pb-4 text-right">

                                                        <a href="javascript:;" class="btn btn-primary saveWOTracker">Add
                                                            Track</a>
                                                        <span id="load-track"></span>

                                                        <a href="javascript:;" class="btn btn-secondary openScheduler">Add
                                                            Scheduler</a>


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row openDateDialog" id="addScheduler" style="width:950px;display:none;">
                                                <div class="col-4 pl-5">
                                                    <div class="form-group">
                                                        <label class="form-label">Scheduler</label>
                                                        <input type="text" class="form-control ron" id="scheduledDate">
                                                    </div>
                                                </div>
                                                <div class="col"><label class="form-label">Time</label>
                                                    <select name="time" id="time" class="form-control custom-select">
                                                        <option value="">Select</option>
                                                        <?php
                                                        $start = strtotime('00:00');
                                                        $end = strtotime('23:59');
                                                        while ($start <= $end) {
                                                            $time = date('H:i:s', $start);
                                                            $sel = ($time == '19:00') ? ' selected' : '';
                                                            // echo "<option value=\"{$time}\"{$sel}>" . date('h.i A', $start) .'</option>';
                                                            echo "<option value=\"{$time}\">" . date('h.i A', $start) . '</option>';
                                                            $start = strtotime('+15 minutes', $start);
                                                        }
                                                        $selectedTime = "12:00";
                                                        $endTime = strtotime("+15 minutes", strtotime($selectedTime));
                                                        echo date('h.i A', $endTime); ?>
                                                    </select>
                                                </div>

                                                <div class="col pr-8"><label class="form-label">Assign to</label>
                                                    <select name="assignTo" id="assignTo" multiple="multiple" class="usersSelect">
                                                        <?php foreach ($users as $us) : ?>
                                                            <option value="<?= $us->id ?>"><?= $us->firstname ?>
                                                                <?= $us->lastname ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <div class="form-group load-assignTo" style="display: none"> </div>

                                                </div>

                                                <div class="col-12 text-right p-3 pr-6">
                                                    <a href="javascript:;" class="btn btn-primary saveWOScheduler">Add
                                                        Track</a>
                                                    <span id="load-schedule"></span>

                                                    <a href="javascript:;" class="btn btn-danger" id="cancelScheduler">Cancel</a>

                                                </div>
                                            </div>
                                        </div>

                                        <!-- End of Add Tracker -->

                                        <!-- View History -->
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-header ">
                                                        <h3 class="card-title"> Track History</h3>

                                                    </div>
                                                    <div class="form-group load-track-history pl-4" style="display: none">

                                                    </div>
                                                    <div class="col pl-4 p-1" id="notFound">

                                                    </div>
                                                    <div class="card-body viewTrackHistory">

                                                    </div>
                                                    <!-- SECTION WRAPPER -->
                                                </div>
                                            </div>
                                            <!-- END -->
                                        </div>
                                        <!-- End of view history-->

                                    </form>
                                </div>
                                <!-- 3 rd tab -->
                                <div class="tab_content">

                                    <div class="container">
                                        <div class="row ">

                                            <div class="modal-body" style="height:400px; width: 950px;">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Title
                                                            </label>
                                                            <input type="text" class="form-control" name="stitle" id="stitle" value="">

                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Time</label>
                                                            <select name="stime" id="stime" class="form-control custom-select">
                                                                <option value="">Select</option>
                                                                <?php
                                                                $start = strtotime('00:00');
                                                                $end = strtotime('23:59');
                                                                while ($start <= $end) {
                                                                    $time = date('H:i:s', $start);
                                                                    $sel = ($time == '19:00') ? ' selected' : '';
                                                                    // echo "<option value=\"{$time}\"{$sel}>" . date('h.i A', $start) .'</option>';
                                                                    echo "<option value=\"{$time}\">" . date('h.i A', $start) . '</option>';
                                                                    $start = strtotime('+15 minutes', $start);
                                                                }
                                                                $selectedTime = "12:00";
                                                                $endTime = strtotime("+15 minutes", strtotime($selectedTime));
                                                                echo date('h.i A', $endTime); ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group has-success">
                                                            <label class="form-label">Date</label>
                                                            <input type="text" class="form-control WOsdatePicker" name="sdate" id="sdate">

                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Assign To </label>

                                                            <select name="sassignTo" id="sassignTo" multiple="multiple">
                                                                <?php foreach ($users as $us) : ?>
                                                                    <option value="<?= $us->id ?>"><?= $us->firstname ?>
                                                                        <?= $us->lastname ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>

                                                        </div>

                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label">Description</label>
                                                        <textarea class="form-control" id="sdesc" name="sdesc" rows="3" style="resize:none"></textarea>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="row">


                                            <div class="col-8 text-right p-3 pr-6">
                                                <button type="button" class="btn btn-primary schedulerSave" onclick="createWOScheduler()">Save</button>
                                                <a href="javascript:;" class="btn btn-danger schedulerSave" id="cancelPopupScheduler">Cancel</a>
                                                <span id="load-scheduler"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
<!-- 4 th tab -->
<div class="tab_content active">
                                    <div class="container">
                                        <div class="span12 text-center load-view-singleWorkOrder">
                                        </div>
                                        <div class="hideForm card-body" style="width: 950px;">

                                            <div class="row viewworkOrderData  w-100">
                                            </div>
                                            <div class="row viewworkorderProductDetails  w-100">
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