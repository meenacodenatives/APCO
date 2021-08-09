@extends('layouts.master')

@section('page-header')
<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title">
            <?php if ($data['type'] == 'Add') : echo $data['type'] ?><?php else : echo $data['type'] ?>
        <?php endif; ?> Lead </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/' . $page='dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/' . $page='leads')}}">leads</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <?php if ($data['type'] == 'Add') : echo $data['type'] ?><?php else : echo $data['type'] ?>
            <?php endif; ?> Lead</li>
        </ol>

    </div>
    <div class="ml-auto pageheader-btn">
        <a href="{{url('/' . $page='leads')}}" class="btn btn-cyan btn-icon text-white">
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
            <div class="container">
                <div class="row">

                    <div class="col-8 p-5">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Location Information</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">State </label>
                                            <select name="state" id="state" class="form-control custom-select">
                                                <option value="">Select</option>
                                            <?php foreach ($data['state'] as $st): ?>
                                            <option value="<?= $st->id ?>" <?php
                                            if ($data['type'] == 'Edit') {
                                            if ($data['lead'][0]->state == $st->id) {
                                            echo 'selected';
                                            }
                                            }
                                            ?>><?= $st->name ?>
                                   <?php endforeach; ?>

                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Region</label>
                                            <select class="form-control" id="region" name="region">
                                                <option value="">Select</option>
                                                <?php foreach ($data['region'] as $re): ?>
                                            <option value="<?= $re->regID ?>" <?php
                                            if ($data['type'] == 'Edit') {
                                            if ($data['lead'][0]->region == $re->regID) {
                                            echo 'selected';
                                            }
                                            }
                                            ?>><?= $re->regName ?>
                                                                            </option>

                                   <?php endforeach; ?>

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
                                                <?php foreach ($data['location'] as $lo): ?>
                                            <option value="<?= $lo->locID ?>" <?php
                                            if ($data['type'] == 'Edit') {
                                            if ($data['lead'][0]->location == $lo->locID) {
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


                                </div>


                            </div>
                        </div>
                        <!-- 2 nd row -->
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label"> Business Name</label>
<input type="text" class="form-control" name="name" id="leadName" value="<?php if ($data['type'] == 'Edit') {echo $data['lead'][0]->name;} ?>" placeholder="Business Name">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label"> Contact Person</label>
<input type="text" class="form-control" value="<?php if ($data['type'] == 'Edit') {
echo $data['lead'][0]->contact_name;} ?>" name="contact_name" id="leadcontactName" placeholder="Contact Person">
                                    </div>
                                </div>

                                <!-- END -->
                                <!-- 3rd row -->

                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label"> Email</label>
<input type="text" class="form-control" name="leadEmail" id="leadEmail" placeholder="Email" value="<?php if ($data['type'] == 'Edit') {
    echo $data['lead'][0]->email;
} ?>">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label"> Phone</label>
<input type="text" maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control" name="phone" id="leadPhone" value="<?php if ($data['type'] == 'Edit') {echo $data['lead'][0]->phone;} ?>" placeholder="Phone">
                                    </div>
                                </div>

                                <!-- END -->
                                <!-- 4th row -->

                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label"> Skype</label>
<input type="text" class="form-control" name="skype" value="<?php if ($data['type'] == 'Edit') {echo $data['lead'][0]->skype_id;} ?>" id="leadSkype" placeholder=" Skype">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label"> Website</label>
<input type="text" class="form-control" value="<?php if ($data['type'] == 'Edit') {
echo $data['lead'][0]->website;} ?>" name="website" id="leadWebsite" placeholder=" Website">
                                    </div>
                                </div>

                                <!-- END -->
                                <!-- 5th row -->

                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label"> Address</label>
                                        <textarea class="form-control" id="address" style="resize:none" placeholder="Address"><?php if ($data['type'] == 'Edit') {
                                        echo $data['lead'][0]->address;
                                        } ?></textarea>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label"> Description</label>
                                <textarea class="form-control" id="description" style="resize:none" placeholder="Description"><?php if ($data['type'] == 'Edit') {
                                echo $data['lead'][0]->description;
                                } ?></textarea>
                                    </div>
                                </div>

                                <!-- END -->
                                <!-- 6th row -->

                                <div class="row">
                                    <div class="col-6 ">
                                        <label class="form-label"> Company Type</label>
<select class="form-control custom-select" id="company_type" data-placeholder="Select" style="resize:none">
<option value="">Select</option>
<?php foreach ($data['company_type'] as $ct) : ?>
<option value="<?= $ct->code ?>" <?php
if ($data['type'] == 'Edit') {
if ($data['lead'][0]->company_type == $ct->code) {
echo 'selected';
}
}
?>><?= $ct->code ?>
</option>
<?php endforeach; ?>
</select>
                                    </div>
                                    <div class="col-6 ">
                                        <label class="form-label"> Status</label>
<select name="status" id="status" class="form-control custom-select">
<option value="">Select</option>
<?php foreach ($data['status'] as $st) : ?>
<option value="<?= $st->code ?>" <?php
if ($data['type'] == 'Edit') {
if ($data['lead'][0]->status == $st->code) {
echo 'selected';
}
}
?>><?= $st->meaning ?>
</option>
<?php endforeach; ?>
</select>
                                    </div>
                                </div>

                                <!-- END -->
                                <!-- 7th row -->

                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label"> Source</label>
<select name="source" id="source" class="form-control custom-select">
<option value="">Select</option>
<?php foreach ($data['source'] as $src) : ?>
<option value="<?= $src->code ?>" <?php
if ($data['type'] == 'Edit') {
if ($data['lead'][0]->source == $src->code) {
echo 'selected';
}
}
?>><?= $src->code ?>
</option>
<?php endforeach; ?>
</select>
                                    </div>

                                    <div class="col-6">
                                        <label class="form-label"> Remarks</label>
<textarea class="form-control" id="remarks" style="resize:none" placeholder="Remarks"><?php if ($data['type'] == 'Edit') {
echo $data['lead'][0]->remarks;
} ?></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 "> </div>
                                    <div class="col-6">
                                        <div style="padding-top:25px;" class="card-footer pull-right  ebtn  pr-2">
                                            <a href="javascript:;" onclick="createLead()" class="btn btn-primary">Save</a>
                                            <a href="{{url('/leads')}}" class="btn btn-danger">Cancel</a>
                                        </div>
                                        <span id="load-lead" style="padding-top:25px;" class="pull-right pr-2"></span>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END -->
                    </div>
                    <div class="col-4 p-5">
                        <div class="card">
                            <div class="card-header">HELP</div>
                            <div class="card-body">
                                <div class="row">
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-warning">Website should be start with
                                            "http://" Example : "http://www.google.com"</li>
                                        <li class="list-group-item list-group-item-dark">Phone should contain numbers
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($data['type'] == 'Edit') : ?>
            <input type="hidden" id="lead_id" value="<?= $data['lead'][0]->id ?>">
        <?php else : ?>
            <input type="hidden" id="lead_id" value="0">
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