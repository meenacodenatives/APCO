@extends('layouts.master')

@section('page-header')
<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <?php //print_r($data); echo "data=".$data; exit;
        ?>
        <h1 class="page-title">
            <?php if ($type == 'Add') : echo $type ?><?php else : echo $type ?>
            <?php endif; ?> Customer </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/' . $page='dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/' . $page='customer')}}">Customer</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <?php if ($type == 'Add') : echo $type ?><?php else : echo $type ?>
                <?php endif; ?> Customer</li>
        </ol>

    </div>
    <div class="ml-auto pageheader-btn">
        <a href="{{url('/' . $page='showCustomer')}}" class="btn btn-cyan btn-icon text-white">
            <span>
                <i class="fe fe-corner-up-left"></i>
            </span> Back
        </a>
    </div>
</div>
<!-- PAGE-HEADER END -->
@endsection
@section('content')
<!-- ROW-1 OPEN -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            @csrf
            <div class="card-header">
                <h3 class="card-title">Basic Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                    <div class="form-group">
                            <label class="form-label"> Customer Name</label>
                            <input type="text" value="@if($customer!=''){{$customer->customer_client_name}}@endif"
                                name="customer_name" id="customer_name" class="form-control" placeholder="Customer Name">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Company Type 
                            </label>
                            <select class="form-control" id="company_type">
                                <option value="">Select</option>
                               
                                <?php foreach ($company_type as $t): ?>
                                <option value="<?= $t->code ?>" <?php
                                            if ($type == 'edit') {
                                                if ($customer->company_type == $t->code) {
                                                    echo 'selected';
                                                }
                                            }
                                            ?>><?= $t->code ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                    <div class="form-group">
                            <label class="form-label">Customer ID</label>
                            <input type="text" value="@if($customer!=''){{ $customer->customer_id}}@endif"
                                name="customer_id" id="customer_id" class="form-control" placeholder="Customer ID">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Board No</label>
                            <input type="text" value="@if($customer!=''){{ $customer->customer_board_no}}@endif"
                                name="board_no" id="board_no" class="form-control" placeholder="Board No">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Contact Name</label>
                            <input type="text" value="@if($customer!=''){{ $customer->customer_contact_name}}@endif"
                                name="contact_name" id="contact_name" class="form-control" placeholder="Contact Name">
                        </div>
                        <div class="form-group">
                            <label class="form-label">GST Number</label>
                            <input type="text" value="@if($customer!=''){{ $customer->customer_gst_number}}@endif"
                                name="customer_gst_number" id="customer_gst_number" class="form-control" placeholder="GST Number">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Customer Choice</label>
                           
                            <select class="form-control" id="customer_choice">
                                <option value="">Select</option>
                                <?php foreach ($choice as $c): ?>
                                <option value="<?= $c->code ?>" <?php
                                            if ($type == 'edit') {
                                                if ('Product' == $c->code) {
                                                    echo 'selected';
                                                }
                                            }
                                            ?>><?= $c->code ?>
                                </option>
                                <?php endforeach; ?>

                               
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select class="form-control" id="customer_status">
                                <?php foreach ($status as $status): ?>
                                <option value="<?= $status->code ?>" <?php
                                            if ($type == 'edit') {
                                                if ($customer->status == $status->code) {
                                                    echo 'selected';
                                                }
                                            }
                                            ?>><?= $status->code ?>
                                </option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-header">
                <h3 class="card-title">Location Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">State</label>
                            <select name="state" id="state" class="form-control custom-select">
                                <option value="">Select</option>
                                <?php foreach ($state as $st): ?>
                                            <option value="<?= $st->id ?>" <?php
                                            if ($type == 'Edit') {
                                            if ($customer->customer_state == $st->id) {
                                            echo 'selected';
                                            }
                                            }
                                            ?>><?= $st->name ?>
                                   <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Region</label>
                            <select class="form-control" id="region" name="region">
                            <option value="">Select</option>
                            <?php foreach ($region as $re): ?>
                                            <option value="<?= $re->regID ?>" <?php
                                            if ($type == 'Edit') {
                                            if ($customer->customer_region == $re->regID) {
                                            echo 'selected';
                                            }
                                            }
                                            ?>><?= $re->regName ?>
                                   <?php endforeach; ?>

                                </option>
                            </select>
                            <div class="form-group load-region" style="display: none">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Location</label>
                            <select class="form-control" id="location" name="location">
                            <option value="">Select</option>
                            <?php foreach ($location as $lo): ?>
                                            <option value="<?= $lo->locID ?>" <?php
                                            if ($type == 'Edit') {
                                            if ($customer->customer_location == $lo->locID) {
                                            echo 'selected';
                                            }
                                            }
                                            ?>><?= $lo->locName ?>
                                                                            </option>

                                   <?php endforeach; ?>
                            </select>
                            <div class="form-group load-location" style="display: none">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" id="customer_address" style="resize:none" placeholder="Address">@if($customer!=''){{ $customer->customer_address}}@endif</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-header">
                <h3 class="card-title">Contact Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Direct No</label>
                            <input type="text" value="@if($customer!=''){{ $customer->customer_direct_no}}@endif"
                                name="customer_direct_no" id="customer_direct_no" class="form-control" placeholder="Direct No">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Secondary Email ID</label>
                            <input type="text" class="form-control" name="customer_email_secondary" id="customer_email_secondary"
                                placeholder="Secondary Email ID"
                                value="@if($customer!=''){{$customer->customer_email_secondary}}@endif">
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Mobile No</label>
                            <input type="text" value="@if($customer!=''){{ $customer->customer_mob_no}}@endif"
                                name="customer_mobile_no" id="customer_mobile_no" class="form-control" placeholder="Mobile No">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Contact Web </label>
                            <input type="text" value="@if($customer!=''){{ $customer->customer_web}}@endif"
                                name="contact_web" id="contact_web" class="form-control" placeholder="Contact Web">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Primary Email ID</label>
                            <input type="text" value="@if($customer!=''){{$customer->customer_email_primary}}@endif"
                                name="customer_email_primary" id="customer_email_primary" class="form-control"
                                placeholder="Primary Email ID">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Contact Mode</label>
                            <input type="text" value="@if($customer!=''){{ $customer->customer_mode}}@endif"
                                name="customer_mode" id="customer_mode" class="form-control" placeholder="Contact Mode">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-md-12">
                    <div class="pull-right ebtn mb-50">
                        <a href="javascript:;" onclick="createCustomer()" class="btn btn-primary customerSave">Save</a>
                        <a href="{{url('/showCustomer')}}" class="btn btn-danger customerSave">Cancel</a>
                   </div>
                   <span id="load-customer" style="padding-top:25px;" class="pull-right pr-2"></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($type == 'Edit') : ?>
<input type="hidden" id="row_id" value="<?= $customer->id ?>">
<input type="hidden" id="dropdownTrigger" value="1">
<input type="hidden" id="editReg" value="<?= $customer->customer_region ?>">
<input type="hidden" id="editLoc" value="<?= $customer->customer_location ?>">

<?php else : ?>
<input type="hidden" id="dropdownTrigger" value="0">
<input type="hidden" id="row_id" value="0">
<?php endif; ?>
<!-- ROW-6 CLOSED -->
@endsection
@section('js')
<!-- INTERNAL  FILE UPLOADES JS -->
<script src="{{URL::asset('assets/js/cn-custom.js')}}"></script>
<script src="{{URL::asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>

<!-- INTERNAL SELECT2 JS -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>

<!-- INTERNAL BOOTSTRAP-DATERANGEPICKER JS -->
<script src="{{URL::asset('assets/plugins/bootstrap-daterangepicker/moment.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

<!-- INTERNAL  TIMEPICKER JS -->
<script src="{{URL::asset('assets/plugins/time-picker/jquery.timepicker.js')}}"></script>
<script src="{{URL::asset('assets/plugins/time-picker/toggles.min.js')}}"></script>

<!-- INTERNAL DATEPICKER JS-->
<script src="{{URL::asset('assets/plugins/date-picker/spectrum.js')}}"></script>
<script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>
<script src="{{URL::asset('assets/plugins/input-mask/jquery.maskedinput.js')}}"></script>

<!-- INTERNAL MULTI SELECT JS -->
<script src="{{URL::asset('assets/plugins/multipleselect/multiple-select.js')}}"></script>
<script src="{{URL::asset('assets/plugins/multipleselect/multi-select.js')}}"></script>

<!--INTERNAL  FORMELEMENTS JS -->
<script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>

<!-- INTERNAL TELEPHONE JS -->
<script src="{{URL::asset('assets/plugins/telephoneinput/telephoneinput.js')}}"></script>
<script src="{{URL::asset('assets/plugins/telephoneinput/inttelephoneinput.js')}}"></script>
@endsection