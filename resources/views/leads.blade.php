@extends('layouts.master')
@section('css')
<link href="{{URL::asset('assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/responsivebootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/fileexport/buttons.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/sweet-alert/sweetalert.css')}}" rel="stylesheet" />
<!-- INTERNAL  DATE PICKER CSS-->
<link href="{{URL::asset('assets/css/pickadate.css')}}" rel="stylesheet">


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
        <a id="leadSearch" class="btn btn-primary btn-icon text-white">
            <span>
                <i class="fe fe-search"></i>
            </span> Advanced search
        </a>
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
    <div style="display:none" class="col-md-12 col-lg-12" id="searchForm">
        <form method="post" name="pdtSearch" action="">

            <div class="card">@csrf
                <div class="card-body">
                    <h1 class="page-title pb-5" id="example-Modal3">Advanced Search</h1>

                    <div class="row">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="form-label text-left">Business Name</label>
                                <input type="text" class="form-control" name="name" id="leadName" placeholder="Name"
                                    value="">

                            </div>
                            <div class="form-group">
                                <label class="form-label text-left">Contact Person</label>
                                <input type="text" class="form-control" name="leadcontactName" id="leadcontactName"
                                    placeholder="ContactPerson" value="">

                            </div>
                            <div class="form-group">
                                <label class="form-label text-left">Email</label>
                                <input type="text" class="form-control" name="leadEmail" id="leadEmail"
                                    placeholder="Email" value="">
                            </div>
                            <div class="form-group">
                                <label class="form-label text-left">Phone</label>
                                <input type="text" class="form-control" name="leadPhone" id="leadPhone"
                                    placeholder="Phone" value="">
                            </div>
                        </div>

                        <div class="col-sm-4">


                            <div class="form-group">
                                <label class="form-label text-left">Created Date - From</label>
                                <input type="text" class="form-control from" name="from" id="from" placeholder="From"
                                    value="">

                            </div>
                            <div class="form-group">
                                <label class="form-label text-left">Status</label>
                                <select style="width:350px;" value="" multiple=multiple name="leadStatus"
                                    id="leadStatus">
                                    <?php foreach ($data['status'] as $st): ?>
                                    <option value="<?= $st->code ?>"><?= $st->meaning ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>

                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="form-group ">
                                <label class="form-label text-left">Created Date - To</label>

                                <input type="text" class="form-control to" name="to" id="to" placeholder="To" value="">


                            </div>
                        </div>
                    </div>
                    <div class="span12 text-center load-search-lead">
                    </div>
                    <div class="row col-xl-12  text-center form p-4">
                        <div class="col-7">
                            <div class="pull-right ebtn  pr-2">
                                <button class="btn btn-primary searchlead" onclick="searchLead()"
                                    type="submit">Search</button>
                                <button class="btn btn-secondary searchlead" onclick="leadresetForm()" type="button">Reset</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-12 col-lg-12">
        <div class="card">
            <!--<div class="card-header">
                <h3 class="card-title">Data Tables</h3>
            </div>-->
            <div class="card-body">
                <div class="table-responsive">
                    <div class="span12 text-center load-search-lead">
                    </div>
                    <table id="table-sortable" class="table table-striped table-bordered text-nowrap w-100">

                        <thead>
                            <tr>
                                <th class="wd-25p">Business Name</th>
                                <th class="wd-10p">Contact Person</th>
                                <th class="wd-25p">E-mail</th>
                                <th class="wd-10p">Phone</th>
                                <th class="wd-10p">Status</th>
                                <th class="wd-10p">Created Date</th>
                                <th class="wd-10p">&nbsp;</th>
                            </tr>
                        </thead>
                        
                        <tbody id="hideLead">
                        @if(count($data['lead']) > 0 )
                                @foreach($data['lead'] as $le)
                            <tr>
                                <td>{{$le->name}}</td>
                                <td>{{$le->contact_name}}</td>
                                <td>{{$le->email}}</td>
                                <td>{{$le->phone}}</td>
                                <td>
                                @foreach($data['status'] as $st) 
                                @if($le->status == $st->code){{$st->meaning}} 
                                    @endif  @endforeach
                                </td>
                                <td>
                                {{date('M d, Y', strtotime($le->created_date))}} 
                                </td>
                                <td>
                                    <a data-toggle="modal" data-target="#mytracker" id="button1"
                                        class="ubtn<?= $le->id; ?> btn btn-primary btn-sm mb-2 mb-xl-0 getLeadname"
                                        data-id=<?= $le->id ?> data-leadName="<?= $le->name ?>">
                                        <i class="fa fa-eye" data-toggle="tooltip" title="ion-plus-circled"></i>
                                    </a>
                                    <a href="{{url('/' . $page='edit-lead')}}/<?= base64_encode($le->id); ?>"
                                        class="ubtn<?= $le->id; ?> btn btn-primary btn-sm mb-2 mb-xl-0"
                                        data-toggle="tooltip" data-original-title="Edit"><i
                                            class="fa fa-pencil"></i></a>&nbsp;&nbsp;
                                    <a id="confirmUserDelete" data-id="<?= $le->id; ?>"
                                        class="ubtn<?= $le->id; ?> btn btn-danger btn-sm mb-2 mb-xl-0"
                                        data-toggle="tooltip" data-original-title="Delete"><i
                                            class="fa fa-trash"></i></a>&nbsp;&nbsp;
                                    <span class="deluser<?= $le->id; ?>"></span>
                                    <a  href="{{url('/' . $page='edit-lead-RFQ')}}/<?= base64_encode($le->id); ?>" class="btn btn-primary btn-sm mb-2 mb-xl-0"><i
                                                class="fa fa-plus"></i></a>
                                </td>
                            </tr>
                            @endforeach
                                @else
                                <tr colspan="8">
                                    <td>No Records Found</td>
                                </tr>
                                @endif

                        </tbody>
                        <tbody id="showLead" style="display:none">

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

<div class="modal" id="mytracker">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="example-Modal3">Lead Tracker - <span class="showContactName lightBlue"></span></h5>
                &nbsp; &nbsp;
                <?php if (count($data['lead']) > 0): ?>
                 <a id="generateRFQ" href="{{url('/' . $page='edit-lead-RFQ')}}/<?= base64_encode($le->id); ?>" class="btn btn-secondary btn-sm">
                     Generate RFQ
                </a> 
                <?php endif; ?>
                <button type="button" class="close closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                
                
                <input type="hidden" name="trac_lead_id" id="trac_lead_id">
                <input type="hidden" name="scheduler_lead_name" id="scheduler_lead_name">

            </div>
          
            <div class="card">

                <div class="card-body p-6">
                    <div class="panel panel-primary">
                        <div class="tab_wrapper first_tab tab-style3">
                            <ul class="tab_list">
                                <li class="active">View Lead</li>
                                <li>Update Tracker</li>
                            </ul>

                            <div class="content_wrapper">
                                <div class="tab_content active">
                                   
                                    <div class="container">
                                    
                                    <div class="span12 text-center load-single-lead">
                                    
                    </div>
                                    <div class="col-sm-2 load-single-lead"> 
                                    </div>
                                        <div class="row hideForm" style="width:700px;">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label class="form-label lightBlue text-capitalize">Business Name
                                                    </label>
                                                    <span id="name"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label lightBlue text-capitalize">Contact
                                                        Name</label>
                                                    <span id="contact_name"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label lightBlue text-capitalize">Email
                                                    </label>
                                                    <span id="email"></span>

                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label lightBlue text-capitalize">Phone</label>
                                                    <span id="phone"></span>
                                                </div>
                                                
                                            </div>
                                            <div class="col">
                                                
                                                <div class="form-group">
                                                    <label class="form-label lightBlue text-capitalize">Skype ID
                                                    </label>
                                                    <span id="skypeID"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label lightBlue text-capitalize">Website</label>
                                                    <span id="website"></span>
                                                </div>
                                                
                                                
                                                <div class="form-group">
                                                    <label class="form-label lightBlue text-capitalize">Address
                                                    </label>
                                                    <span id="address"></span>

                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label lightBlue text-capitalize">Company
                                                        Type</label>
                                                    <span id="company_type"></span>
                                                </div>
                                            </div>
                                            <div class="col">
                                            <div class="form-group">
                                                    <label class="form-label lightBlue text-capitalize">Source</label>
                                                    <span id="source"></span>
                                                </div>
                                              
                                                
                                                <div class="form-group">
                                                    <label class="form-label lightBlue text-capitalize">Remarks</label>
                                                    <span id="remarks"></span>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="form-label lightBlue text-capitalize">Last Tracked
                                                        Date</label>
                                                    <span id="lastTrackedDate"></span>
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                        <div class="row hideForm" style="width:700px;">
                                        <div class="form-group">
                                                    <label
                                                        class="form-label lightBlue text-capitalize">Description</label>
                                                    <span id="description"></span>
                                                </div>
                                        </div>
                                        <div class="row hideForm" style="width:700px;">
                                        <div class="form-group">
                                                    <label class="form-label lightBlue text-capitalize">Last Tracked
                                                        Comment</label>
                                                    <span id="lastTrakedComment"></span>
                                         </div>
                                        </div>
                                    </div>


                                </div>

                                <div class="tab_content">
                                    <form>
                                        <div class="container">
                                            <!-- Row -->
                                            <div class="row tracForm" style="width:700px;">
                                                <div class="col-xs-9 col-md-7">
                                                    <div class="form-group">
                                                        <label class="form-label">Comment</label>
                                                        <textarea class="form-control" value="" name="comment"
                                                            id="comment" placeholder="Comment"
                                                            style="width:380px;height:160px; resize:none"></textarea>
                                                    </div>
                                                    </div>
                                                    <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label class="form-label">Contact Mode</label>
                                                        <select name="contactType" id="contact_type" class="form-control custom-select">
                                            <option value="">Select</option>
                                            <?php foreach ($data['contactType'] as $ct): ?>
                                            <option value="<?= $ct->code ?>" ><?= $ct->meaning ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select> 
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Notify To</label>
                                                        <select name="notify_users" multiple="multiple"
                                                            id="notify_users">
                                                            <?php foreach ($data['users'] as $us): ?>
                                                            <option value="<?= $us->id ?>"><?= $us->firstname ?>
                                                                <?= $us->lastname ?> </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-xs-9 pb-4 text-right">

                                        <a href="javascript:;" class="btn btn-primary saveTracker">Add
                                            Track</a>
                                        <span id="load-track"></span>

                                        <a href="javascript:;" class="btn btn-secondary openScheduler">Add
                                            Scheduler</a>


                                    </div>
                                                </div>
                                            </div>

                                            <div class="row openDateDialog" id="addScheduler" style="width:700px;display:none;">
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
                                
                                <div class="col pr-8"><label class="form-label">Assign to</label>
                                    <select name="assignTo" id="assignTo" multiple="multiple" class="usersSelect">
                                        <?php foreach ($data['users'] as $us): ?>
                                        <option value="<?= $us->id ?>"><?= $us->firstname ?> <?= $us->lastname ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="form-group load-assignTo" style="display: none"> </div>

                                </div>

                                <div class="col-12 text-right p-3 pr-6">
                                    <a href="javascript:;" class="btn btn-primary saveScheduler">Add Track</a>
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
                                                        <div class="form-group load-track-history pl-4"
                                                            style="display: none">

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


                                        </div>
                                    </form>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>




        </div>

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