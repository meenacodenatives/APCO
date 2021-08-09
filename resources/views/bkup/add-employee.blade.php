@extends('layouts.master')
@section('css')
<!-- INTERNAL SELECT2 CSS -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<!-- INTERNAL  DATE PICKER CSS-->
<link href="{{URL::asset('assets/plugins/date-picker/spectrum.css')}}" rel="stylesheet" />
@endsection
@section('page-header')


<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
        <h1 class="page-title"><?php if ($data['type'] == 'add'): ?>Add<?php else: ?> Edit<?php endif; ?> Employee</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/' . $page='dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/' . $page='employees')}}">Employees</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <?php if ($data['type'] == 'add'): ?>Add<?php else: ?> Edit<?php endif; ?> Employee</li>
        </ol>
    </div>
    <div class="ml-auto pageheader-btn">
        <a href="{{url('/' . $page='employees')}}" class="btn btn-cyan btn-icon text-white">
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

    <div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Basic Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="exampleInputname">First Name</label>
                            <input type="text" class="form-control" id="fname" placeholder="First Name" value="<?php if ($data['type'] == 'edit') {
    echo $data['employee'][0]->firstname;
} ?>">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="exampleInputname1">Last Name</label>
                            <input type="text" class="form-control" id="lname" placeholder="Last Name" value="<?php if ($data['type'] == 'edit') {
    echo $data['employee'][0]->lastname;
} ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="exampleInputname">Email</label>
                            <input type="text" class="form-control" id="email" placeholder="Email"
                                <?php if ($data['type'] == 'edit'):?> readonly <?php endif; ?> value="<?php if ($data['type'] == 'edit') {
    echo $data['employee'][0]->email;
} ?>">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="exampleInputname1">Phone</label>
                            <input type="text" maxlength="10"
                                onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control"
                                id="phone" placeholder="Phone" value="<?php if ($data['type'] == 'edit') {
    echo $data['employee'][0]->phone;
} ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="exampleInputname">Date Of Birth</label>
                            <input type="text" class="form-control dob" id="dob" placeholder="Date Of Birth" value="<?php if ($data['type'] == 'edit') {
    echo $data['employee'][0]->dob;
} ?>">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="exampleInputname1">Gender</label>
                            <select class="form-control" id="gender">
                                <option value="">Select</option>
                                <?php foreach ($data['gender'] as $gender): ?>
                                <option value="<?= $gender->code ?>" <?php
                                            if ($data['type'] == 'edit') {
                                                if ($data['employee'][0]->gender == $gender->code) {
                                                    echo 'selected';
                                                }
                                            }
                                            ?>><?= $gender->code ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" id="address" style="resize:none" placeholder="Address"><?php if ($data['type'] == 'edit') {
    echo $data['employee'][0]->address;
} ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-xl-6 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Official Information</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="exampleInputname">Primary Country</label>
                            <select class="form-control" id="country">
                                <option value="">Select</option>
                                <?php foreach ($data['country'] as $country): ?>
                                <option value="<?= $country->code ?>" <?php
                                            if ($data['type'] == 'edit') {
                                                if ($data['employee'][0]->country == $country->code) {
                                                    echo 'selected';
                                                }
                                            }
                                            ?>><?= $country->name ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group ">
                            <label for="exampleInputname1">Location</label>
                            <select class="form-control location" id="location">
                                <option value="">Select</option>
                            </select>
                            <div class="form-group load-location" style="display: none">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="exampleInputname">Category</label>
                            <select class="form-control" id="category">
                                <option value="">Select</option>
                                <?php foreach ($data['usersCategory'] as $cat): ?>
                                <option value="<?= $cat->id ?>" <?php
                                            if ($data['type'] == 'edit') {
                                                if ($data['employee'][0]->user_category == $cat->id) {
                                                    echo 'selected';
                                                }
                                            }
                                            ?>><?= $cat->category_name ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="exampleInputname1">Status</label>
                            <select class="form-control" id="status">
                                <?php foreach ($data['status'] as $status): ?>
                                <option value="<?= $status->code ?>" <?php
                                            if ($data['type'] == 'edit') {
                                                if ($data['employee'][0]->status == $status->code) {
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
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="exampleInputname">Joining Date</label>
                            <input type="text" class="form-control doj" id="doj" placeholder="Joining Date" value="<?php if ($data['type'] == 'edit') {
    echo $data['employee'][0]->joining_date;
} ?>">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="examp1">Relieve Date</label>
                            <input type="text" class="form-control dor" id="dor" placeholder="Relieve Date" value="<?php if ($data['type'] == 'edit') {
    echo $data['employee'][0]->relieve_date;
} ?>">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                            <label>Relieve Reason</label>
                            <textarea class="form-control" style="resize:none" id="relieve"
                                placeholder="Relieve Reason"><?php if ($data['type'] == 'edit') {
    echo $data['employee'][0]->relieve_reason;
} ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-xl-6 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Password</div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="exampleInputname">New Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="exampleInputname1">Confirm Password</label>
                            <input type="password" class="form-control" id="cpassword" placeholder="Confirm Password">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--<div class="col-lg-4 col-xl-6 col-md-12 col-sm-12">

        <div class="card">
            <div class="card-header">
                <div class="card-title">Help</div>
            </div>
            <div class="card-body">
                <p>Email address and phone number should be unique</p>                       
                <p>Password should have atleast 8 characters</p>
                <p>Password should contain alphanumeric</p>
            </div>

        </div>

    </div>-->

    <div class="col-lg-12 col-xl-6 col-md-12 col-sm-12">
        <div class="card-footer text-left ebtn">
            <a href="javascript:;" onclick="saveEmployee()" class="btn btn-primary">Save</a>
            <a href="{{url('/' . $page='employees')}}" class="btn btn-danger">Cancel</a>
        </div>
        <span id="load-employee"></span>
    </div>
</div>
<?php if ($data['type'] == 'edit'): ?>
<input type="hidden" id="user_id" value="<?= $data['employee'][0]->id ?>">
<input type="hidden" id="triggerLocation" value="1">
<input type="hidden" id="editLocation" value="<?= $data['employee'][0]->location ?>">
<?php else: ?>
<input type="hidden" id="triggerLocation" value="0">
<input type="hidden" id="user_id" value="0">
<?php endif; ?>


<!-- ROW-1 CLOSED -->
@endsection
@section('js')
<!-- INTERNAL SELECT2 JS -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{URL::asset('assets/js/select2.js')}}"></script>
<script src="{{URL::asset('assets/plugins/date-picker/spectrum.js')}}"></script>
<script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>
<script src="{{URL::asset('assets/plugins/input-mask/jquery.maskedinput.js')}}"></script>

<script>

</script>

@endsection