@extends('layouts.master')
@section('css')
<!-- INTERNAL C3 CHARTS CSS -->
<link href="{{URL::asset('assets/plugins/charts-c3/c3-chart.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/css/pickadate.css')}}" rel="stylesheet">
<!-- INTERNAL FULL CALENDAR CSS -->
<link href="{{URL::asset('assets/plugins/fullcalendar/fullcalendar.css')}}" rel='stylesheet' />
<link href="{{URL::asset('assets/plugins/fullcalendar/fullcalendar.print.min.css')}}" rel='stylesheet' media='print' />
<link href="{{URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet" />

<!-- INTERNAL SELECT2 CSS -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<!-- INTERNAL  MULTI SELECT CSS -->
<link rel="stylesheet" href="{{URL::asset('assets/plugins/multipleselect/multiple-select.css')}}">
@endsection
@section('page-header')
<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">Schedular</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/' . $page='dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Schedular</li>
        </ol>
    </div>


    <div class="ml-auto pageheader-btn">
        <a href="javascript:;" data-toggle="modal" data-target="#schedular-popup" id="openSchedule"
            class="btn btn-secondary btn-icon text-white mr-2">
            <span> New Schedule
                <i class="fe fe-plus"></i>
            </span>
        </a>
    </div>
</div>
<!-- PAGE-HEADER END -->

<!-- SCHEDULAR MODAL -->
<div class="modal fade" id="schedular-popup" tabindex="-1" role="dialog" aria-labelledby="schedular-popup"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title showTitle" id="example-Modal3"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="col-sm-2"> <span class="load-schedular "></span>
            </div>

            <div class="hideForm">
                <div class="modal-body" style="height:500px; ">

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
                        $start=strtotime('00:00');
                        $end=strtotime('23:59');
                        while ($start <= $end) {
                        $time = date('H:i:s', $start);
                        $sel = ($time == '19:00') ? ' selected' : '';
                        // echo "<option value=\"{$time}\"{$sel}>" . date('h.i A', $start) .'</option>';
                        echo "<option value=\"{$time}\">" . date('h.i A', $start) .'</option>';
                        $start = strtotime('+15 minutes', $start);
                        }   
                        $selectedTime = "12:00";
                        $endTime = strtotime("+15 minutes", strtotime($selectedTime));
                        echo date('h.i A', $endTime); ?>
                                </select>
                                <span id="load_stime"></span>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group has-success">
                                <label class="form-label">Date</label>
                                <input type="text" class="form-control" name="sdate" id="sdate">
                                <span id="load_sdate"></span>

                            </div>
                            <div class="form-group  has-danger">
                                <label class="form-label">Timezone</label>
                                <select name="stimezone" id="stimezone" class="form-control custom-select">
                                    <option value="">Select</option>
                                    <?php foreach ($region as $re): ?>
                                    <option value="<?= $re->id ?>"> <?= $re->name ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <span id="load_stimezone"></span>

                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="sdesc" name="sdesc" rows="3"
                                style="resize:none"></textarea>
                            <span id="load_sdesc"></span>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="margin-top:16px">
                            <div class="form-group">
                                <label class="form-label">Assign To</label>
                                <select name="sassignTo" id="sassignTo" multiple="multiple">
                                    <?php foreach ($users as $us): ?>
                                    <option value="<?= $us->id ?>"><?= $us->firstname ?> <?= $us->lastname ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <span id="load_sassignTo"></span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="scheduler-h-divider"></div>
           
            <div class="row">

                <div class="col-4 p-3 pl-6">
                        <div id="delDiv" >
                            <button type="button" class="btn btn-danger mr-auto"
                                id="schedularConfirmUserDelete">Delete</button>
                        </div>
                        <span id="load-del-scheduler"></span>
                </div>

                <div class="col-8 text-right p-3 pr-6">
                        <button type="button" class="btn btn-primary schedulerSave"
                            onclick="createScheduler()">Save</button>
                        <button type="button" class="btn btn-secondary schedulerSave"
                            data-dismiss="modal">Close</button>
                        <span id="load-scheduler"></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- SCHEDULAR MODAL CLOSED -->


@endsection
@section('content')
<!-- ROW OPEN -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <!--<h3 class="card-title">Calender With different Color Events</h3>-->
            </div>
            <div class="card-body">
                <div id='calendar1'></div>
            </div>
        </div>
    </div>
    <input type="hidden" id="schedular_id" value="">
    <input type="hidden" id="all_schedules" value='<?= $schedules ?>'>
</div>
<!-- ROW CLOSED -->
@endsection
@section('js')
<!-- INTERNAL FULL CALENDAR JS -->
<script src="{{URL::asset('assets/plugins/fullcalendar/moment.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fullcalendar/jquery-ui.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fullcalendar/fullcalendar.min.js')}}"></script>
<script src="{{URL::asset('assets/js/fullcalendar.js')}}"></script>
<script src="{{URL::asset('assets/js/picker.js')}}"></script>
<script src="{{URL::asset('assets/js/picker.date.js')}}"></script>
<script src="{{URL::asset('assets/js/picker.time.js')}}"></script>
<!-- INTERNAL SWEET-ALERT JS -->
<script src="{{URL::asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>
<script src="{{URL::asset('assets/js/sweet-alert.js')}}"></script>
<!-- INTERNAL SELECT2 JS -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<!-- INTERNAL MULTI SELECT JS -->
<script src="{{URL::asset('assets/plugins/multipleselect/multiple-select.js')}}"></script>
<script src="{{URL::asset('assets/plugins/multipleselect/multi-select.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
@endsection