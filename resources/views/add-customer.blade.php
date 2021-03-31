@extends('layouts.master')

@section('page-header')
<!-- PAGE-HEADER -->
<div class="page-header">
    <div>
    <?php //print_r($data); echo "data=".$data['customer']->id; exit;?>
        <h1 class="page-title"> <?php if ($data['type'] == 'Add'): echo $data['type']?><?php else: echo $data['type']?>
            <?php endif; ?> Customer </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('/' . $page='dashboard')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{url('/' . $page='customer')}}">Customer</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                <?php if ($data['type'] == 'Add'): echo $data['type']?><?php else: echo $data['type']?>
                <?php endif; ?> Customer</li>
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
                            <div class="card-body">
                                <div class="row">
                                    
                                    <div class="col-4">
                                        <div class="form-group classWithPad">
                                            <label class="form-label"> Location</label>
                                            <select name="location" id="location-dropdown"
                                                class="form-control custom-select">
                                                <option value="">Select</option>
                                            <?php foreach ($data['location'] as $loc): ?>
                                            <option value="<?= $loc->locID ?>" <?php
                                            if ($data['type'] == 'Edit') {
                                                if ($data['customer']->cnct_location == $loc->locID) {
                                                    echo 'selected';
                                                }
                                            }
                                            ?>><?= $loc->locName ?>
                                            </option>
                                            <?php endforeach; ?>

                                            </select>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 2 nd row -->
                        <div class="card">
                            <div class="card-body">
                                
                                </div>

                                <!-- END -->
                                <!-- 3rd row -->

                                <div class="row">
                                    
                                </div>

                                <!-- END -->
                                <!-- 4th row -->

                                <div class="row">
                                    
                                </div>

                                <!-- END -->
                                <!-- 5th row -->

                                <div class="row">
                                   
                                </div>

                                <!-- END -->
                                <!-- 6th row -->

                                <div class="row">
                                    
                                </div>

                                <!-- END -->
                                <!-- 7th row -->

                                <div class="row">
                                <div class="col-6">
                                        <div style="padding-top:25px;" class="card-footer pull-right  ebtn  pr-2">
                                            <a href="javascript:;" onclick="createCustomer()"
                                                class="btn btn-primary">Save</a>
                                            <a href="{{url('/customers')}}" class="btn btn-danger">Cancel</a>
                                        </div>
                                        <span id="load-customer" style="padding-top:25px;" class="pull-right pr-2"></span>

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
                                <li class="list-group-item list-group-item-warning">Website should be start with "http://" Example : "http://www.google.com"</li>
                                <li class="list-group-item list-group-item-dark">Phone should contain numbers</li>
                                </ul>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($data['type'] == 'Edit'): ?>
        <input type="hidden" id="customer_id" value="<?= $data['customer']->id ?>">
        <input type="hidden" id="dropdownTrigger" value="1">
        <input type="hidden" id="editReg" value="<?= $data['customer']->cnct_region ?>">
        <input type="hidden" id="editLoc" value="<?= $data['customer']->cnct_location ?>">

        <?php else: ?>
        <input type="hidden" id="dropdownTrigger" value="0">
        <input type="hidden" id="customer_id" value="0">
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