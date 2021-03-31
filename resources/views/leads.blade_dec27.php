@extends('layouts.master')
@section('css')
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/fileexport/buttons.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet" />
<!-- INTERNAL  DATE PICKER CSS-->
<link href="{{URL::asset('assets/plugins/date-picker/spectrum.css')}}" rel="stylesheet" />
<!-- INTERNAL PRISM CSS -->
<link href="{{URL::asset('assets/plugins/prism/prism.css')}}" rel="stylesheet">
@endsection
@section('page-header')

<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">Leads</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/' . $page='dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Leads</li>
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
                                    <a data-toggle="modal" data-target="#mytracker" id="button1"
                                        class="btn btn-primary btn-sm mb-2 mb-xl-0 getLeadname" data-id=<?= $le->id ?>
                                        data-name=<?= $le->name ?>>
                                        <i class="ion-plus-circled" data-toggle="tooltip" title="ion-plus-circled"></i>
                                    </a>
                                    <a href="{{url('/' . $page='edit-lead')}}/<?= encrypt($le->id); ?>"
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
<!-- .modal -->

<div class="modal fade" id="mytracker" role="dialog" aria-labelledby="modalLabel" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Lead Tracker <span class="showContactName"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <input type="hidden" name="trac_lead_id" id="trac_lead_id">
                <input type="hidden" name="scheduler_lead_name" id="scheduler_lead_name">
            </div>
            <div class="modal-body">
                <!-- Row -->
                <div class="row tracForm">
                <div class="card">

                    <div class="col-md-8 pl-5 p-3"><textarea class="form-control" value="" name="comment" id="comment"
                            placeholder="Comment" style="height: 160px; resize:none"></textarea>
                    </div>
                    <div class="col-md-4">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-3">
                            <select name="contactType" id="contact_type" class="form-control custom-select">

                            </select>
                            <div class="form-group load-location" style="display: none"></div>


                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-3">
                            <select name="Notifiers" id="notify_users" class="multi form-control">

                            </select>
                            <div class="form-group load-location" style="display: none"></div>

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-3">
                            <a href="javascript:;" id="hideTrack" class="btn btn-primary saveTracker">Add
                                Track</a>
                            <a href="javascript:;" class="btn btn-secondary openSchedulerButton">Add
                                Scheduler</a>


                        </div>
                    </div>
                </div>
                <!-- END-->
                <div class="row openDateDialog" id="addScheduler" style="display:none;">
                    <div class="col-3 pl-5"><label class="form-label">Scheduler</label>

                        <input type="text" class="form-control" id="scheduledDate" placeholder="Scheduled Date"
                            value="">
                    </div>
                    <div class="col-3"><label class="form-label">Time</label>

                        <select name="time" id="time" class="form-control custom-select">
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
                    </div>
                    <div class="col-3"><label class="form-label">Region</label>
                        <select name="region" id="region" class="form-control custom-select">

                        </select>
                        <div class="form-group load-location" style="display: none"></div>

                    </div>
                    <div class="col-3 pr-5"><label class="form-label">Assign to</label>
                        <select name="assignTo" id="assignTo" class="form-control assignTo">
                        </select>
                        <div class="form-group load-location" style="display: none"> </div>

                    </div>
                    <div class="col-12 text-right p-3 pr-6">
                        <a href="javascript:;" class="btn btn-primary saveScheduler">Add Track</a>
                        <a href="javascript:;" class="btn btn-danger" id="cancelScheduler">Cancel</a>

                    </div>
                </div>
                

                    <!-- View History -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header ">
                                    <h3 class="card-title"> Track History</h3>
                                    
                                </div>
                                <div class="form-group load-location" style="display: none">
 
                                </div>
                                <div class="card-body viewTrackHistory">
                                
                            </div>
                            <!-- SECTION WRAPPER -->
                        </div>
                    </div>
                    <!-- END -->
                </div>
                <!-- End of view history-->
            </div>
        </div>
    </div>
</div>
</div>

<!-- MESSAGE MODAL CLOSED -->



@endsection
@section('js')
<!-- INTERNAL CHARTJS CHART JS -->
<script src="{{URL::asset('assets/plugins/datatable/jquery.dataTables.min.js')}}"></script>
<!-- <script src="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/datatable.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script> -->
<!--INTERNAL  POPOVER JS -->
<script src="{{URL::asset('assets/js/popover.js')}}"></script>
<!-- INTERNAL SWEET-ALERT JS -->
<script src="{{URL::asset('assets/plugins/sweet-alert/sweetalert.min.js')}}"></script>
<script src="{{URL::asset('assets/js/sweet-alert.js')}}"></script>
<!-- INTERNAL DATEPICKER JS-->
<script src="{{URL::asset('assets/plugins/date-picker/spectrum.js')}}"></script>
<script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>
<script src="{{URL::asset('assets/plugins/input-mask/jquery.maskedinput.js')}}"></script>

@endsection