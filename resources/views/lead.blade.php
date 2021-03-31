@extends('layouts.master')
@section('css')
		<!-- INTERNAL  FILE UPLODE CSS -->
		<link href="{{URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css" />

		<!-- INTERNAL SELECT2 CSS -->
		<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />

		<!-- INTERNAL BOOTSTRAP-DATERANGEPICKER CSS -->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}">

		<!-- INTERNAL  TIME PICKER CSS -->
		<link href="{{URL::asset('assets/plugins/time-picker/jquery.timepicker.css')}}" rel="stylesheet" />

		<!-- INTERNAL  DATE PICKER CSS-->
		<link href="{{URL::asset('assets/plugins/date-picker/spectrum.css')}}" rel="stylesheet" />

		<!-- INTERNAL  MULTI SELECT CSS -->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/multipleselect/multiple-select.css')}}">

		<!-- INTERNAL TELEPHONE CSS-->
		<link rel="stylesheet" href="{{URL::asset('assets/plugins/telephoneinput/telephoneinput.css')}}">
@endsection
@section('page-header')
			<!-- PAGE-HEADER -->
			<div class="page-header">
				<div>
					<h1 class="page-title">Form Elements</h1>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Forms</a></li>
						<li class="breadcrumb-item active" aria-current="page">Form Elements</li>
					</ol>
				</div>
				<div class="ml-auto pageheader-btn">
					<a href="#" class="btn btn-primary btn-icon text-white mr-2">
						<span>
							<i class="fe fe-shopping-cart"></i>
						</span> Add Order
					</a>
					<a href="#" class="btn btn-secondary btn-icon text-white">
						<span>
							<i class="fe fe-plus"></i>
						</span> Add User
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
						<div class="card-header">
							<h3 class="mb-0 card-title">Default forms</h3>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<input type="text" class="form-control" name="input" placeholder="Enter Your Name">
									</div>
									<div class="form-group">
										<input type="text" class="form-control" name="example-disabled-input" placeholder="Read Only Text area." readonly="">
									</div>
									<div class="form-group">
										<input type="text" class="form-control" name="example-disabled-input" placeholder="Disabled text area.." disabled="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group has-success">
										<input type="text" class="form-control is-valid state-valid" name="example-text-input-valid" placeholder="Valid Email..">
									</div>
									<div class="form-group  has-danger">
										<input type="text" class="form-control is-invalid state-invalid" name="example-text-input-invalid" placeholder="Invalid feedback">
									</div>
									<div class="form-group">
										<input type="password" class="form-control" name="example-password-input" placeholder="Password..">
									</div>
								</div>
								<div class="col-md-12">
									<textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Write a large text here ..."></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-header">
							<h3 class="mb-0 card-title">Default forms with labels</h3>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label">Enter Name</label>
										<input type="text" class="form-control" name="example-text-input" placeholder="Name">
									</div>
									<div class="form-group">
										<label class="form-label">Disabled</label>
										<input type="text" class="form-control" name="example-disabled-input" placeholder="Disabled text area.." value="" disabled="">
									</div>
									<div class="form-group">
										<label class="form-label">Readonly</label>
										<input type="text" class="form-control" name="example-disabled-input" placeholder="Read Only Text area." readonly="">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="form-label">Valid Email</label>
										<input type="text" class="form-control is-valid state-valid" name="example-text-input-valid" placeholder="Valid Email..">
									</div>
									<div class="form-group m-0">
										<label class="form-label">Invalid Number</label>
										<input type="text" class="form-control is-invalid state-invalid" name="example-text-input-invalid" placeholder="Invalid Number..">
										<div class="invalid-feedback">Invalid feedback</div>
									</div>
									<div class="form-group">
										<label class="form-label">Password</label>
										<input type="password" class="form-control" name="example-password-input" placeholder="Password..">
									</div>
								</div>
								<div class="col-md-12 ">
									<div class="form-group mb-0">
										<label class="form-label">Message</label>
										<textarea class="form-control" name="example-textarea-input" rows="4" placeholder="text here.."></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- COL END -->
				<!-- <div class="col-lg-6">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Input Forms</h3>
						</div>
						<div class="card-body">

							<div class="form-group">
								<label class="form-label">Text</label>
								<input type="text" class="form-control" name="example-text-input" placeholder="Text..">
							</div>

							<div class="form-group">
								<label class="form-label">Country</label>
								<select name="country" id="select-countries" class="form-control custom-select">
									<option value="br" data-data="{&quot;image&quot;: &quot;{{URL::asset('assets/images/flags/br.svg&quot;')}}}">Brazil</option>
									<option value="cz" data-data="{&quot;image&quot;: &quot;{{URL::asset('assets/images/flags/cz.svg&quot;')}}}">Czech Republic</option>
									<option value="de" data-data="{&quot;image&quot;: &quot;{{URL::asset('assets/images/flags/de.svg&quot;')}}}">Germany</option>
									<option value="pl" data-data="{&quot;image&quot;: &quot;{{URL::asset('assets/images/flags/pl.svg&quot;')}}}" selected="">Poland</option>
								</select>
							</div>
							<div class="form-group">
								<label class="form-label">Input group</label>
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Search for...">
									<span class="input-group-append">
										<button class="btn btn-primary" type="button">Go!</button>
									</span>
								</div>
							</div>
							<div class="form-group mb-0">
								<label class="form-label">Input group buttons</label>
								<div class="input-group">
									<input type="text" class="form-control">
									<div class="input-group-append">
										<button type="button" class="btn btn-primary">Action</button>
										<button data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle"></button>
										<div class="dropdown-menu dropdown-menu-right">
											<a class="dropdown-item" href="javascript:void(0)">News</a>
											<a class="dropdown-item" href="javascript:void(0)">Messages</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item" href="javascript:void(0)">Edit Profile</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div> -->
				<!-- COL END -->
				
			<!-- ROW-6 CLOSED -->
@endsection
@section('js')
		<!-- INTERNAL  FILE UPLOADES JS -->
		<script src="{{URL::asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
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