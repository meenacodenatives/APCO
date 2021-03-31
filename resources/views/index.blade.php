@extends('layouts.master')
@section('css')
		<!-- INTERNAL  MORRIS CSS -->
		<link href="{{URL::asset('assets/plugins/morris/morris.css')}}" rel="stylesheet" />
@endsection
@section('page-header')

			<!-- PAGE-HEADER -->
			<div class="page-header">
				<div>
					<h1 class="page-title">APP Dashboard</h1>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">APP Dashboard</li>
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
			<!-- ROW-1 -->
			<div class="row">
				<div class="col-md-12">
					<div class="card  banner">
						<div class="card-body">
							<div class="row">
								<div class="col-xl-3 col-lg-2 text-center">
									<img src="{{URL::asset('assets/images/pngs/dash4.png')}}" alt="img" class="w-95">
								</div>
								<div class="col-xl-9 col-lg-10 pl-lg-0">
									<div class="row">
										<div class="col-xl-7 col-lg-6">
											<div class="text-left text-white mt-xl-4">
												<h3 class="font-weight-semibold">Congratulations Steven</h3>
												<h4 class="font-weight-normal">You Cources Reached your targeted milestone</h4>
												<p class="mb-lg-0 text-white-50">If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.</p>
											</div>
										</div>
										<div class="col-xl-5 col-lg-6 text-lg-center mt-xl-4">
											<h5 class="font-weight-semibold mb-1 text-white">Students Subscribed</h5>
											<h2 class="display-2 mb-3 number-font text-white">50M</h2>
											<div class="btn-list mb-xl-0">
												<a href="#" class="btn btn-dark mb-xl-0">Check Details</a>
												<a href="#" class="btn btn-white mb-xl-0" id="skip">No, Thanks</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ROW-1 End-->

			<!-- ROW-1 OPEN -->
			<div class="row">
				<div class="col-xl-3 col-sm-6">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col">
									<div class="dash1">
										<p class="mb-1">Total Students</p>
										<h3 class="mb-1 number-font">479</h3>
										<span class="fs-12 text-muted"><i class="fe fe-trending-up"></i> <strong> 2.6%</strong> <span class="text-muted fs-12 ml-0 mt-1">than last week</span></span>
									</div>
								</div>
								<div class="col col-auto">
									<p class="data-attributes mb-0 mt-3">
										<span data-peity='{ "fill": ["#ec5444", "#e3e8f7"],   "innerRadius": 20, "radius": 24 }'>5/7</span>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-sm-6">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col">
									<div class="dash1">
										<p class="mb-1">Total Instructors</p>
										<h3 class="mb-1 number-font">534</h3>
										<span class="fs-12 text-muted"><i class="fe fe-trending-down"></i> <strong> 0.5%</strong> <span class="text-muted fs-12 ml-0 mt-1">than last week</span></span>
									</div>
								</div>
								<div class="col col-auto">
									<p class="data-attributes mb-0 mt-3">
										<span data-peity='{ "fill": ["#1cc5ef", "#e3e8f7"],   "innerRadius": 20, "radius": 24 }'>4/7</span>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-sm-6">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col">
									<div class="dash1">
										<p class="mb-1">Total Courses</p>
										<h3 class="mb-1 number-font">487</h3>
										<span class="fs-12 text-muted"><i class="fe fe-trending-up"></i> <strong> 1.5%</strong> <span class="text-muted fs-12 ml-0 mt-1">than last week</span></span>
									</div>
								</div>
								<div class="col col-auto">
									<p class="data-attributes mb-0 mt-3">
										<span data-peity='{ "fill": ["#24e4ac", "#e3e8f7"],   "innerRadius": 20, "radius": 24 }'>6/7</span>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-sm-6">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col">
									<div class="dash1">
										<p class="mb-1">Total Assignments</p>
										<h3 class="mb-1 number-font">84</h3>
										<span class="fs-12 text-muted"><i class="fe fe-trending-down"></i> <strong> 0.6%</strong> <span class="text-muted fs-12 ml-0 mt-1">than last week</span></span>
									</div>
								</div>
								<div class="col col-auto">
									<p class="data-attributes mb-0 mt-3">
										<span data-peity='{ "fill": ["#f18238", "#e3e8f7"],   "innerRadius": 20, "radius": 24 }'>3/7</span>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ROW-1 CLOSED -->

			<!-- ROW-2 OPEN -->
			<div class="row">
				<div class="col-lg-8 col-md-12 col-sm-12 col-xl-8">
					<div class="card overflow-hidden">
						<div class="card-header">
							<h3 class="card-title">Learners with Time Sent Monthlywise</h3>
						</div>
						<div class="card-body">
							<div id="learners"></div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-12 col-sm-12 col-xl-4">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Course Progress</h3>
						</div>
						<div class="card-body">
							<div id="morrisBar8" class="h-250"></div>
							<div class="row mt-2">
								<div class="col-md-6 col-6 text-center mb-4">
									<div class="p-2 task-box mb-0">
										<span class="fs-12 badge badge-default"><span class="dot-label bg-secondary mr-2"></span>Completed</span>
										<h5 class="mt-1 mb-0 number-font1 font-weight-semibold">3,567</h5>
									</div>
								</div>
								<div class="col-md-6 col-6 text-center mb-4">
									<div class="p-2 task-box mb-0">
										<span class="fs-12 badge badge-default"><span class="dot-label bg-purple mr-2"></span>In Progress</span>
										<h5 class="mt-1 mb-0 number-font1 font-weight-semibold">1,456</h5>
									</div>
								</div>
								<div class="col-md-6 col-6 text-center mb-4 mb-lg-0">
									<div class="p-2 task-box mb-0">
										<span class="fs-12 badge badge-default"><span class="dot-label bg-secondary1 mr-2"></span>Not Completed</span>
										<h5 class="mt-1 mb-0 number-font1 font-weight-semibold">456</h5>
									</div>
								</div>
								<div class="col-md-6 col-6 text-center">
									<div class="p-2 task-box mb-0">
										<span class="fs-12 badge badge-default"><span class="dot-label bg-pink mr-2"></span>Not Started</span>
										<h5 class="mt-1 mb-0 number-font1 font-weight-semibold">133</h5>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ROW-2 CLOSED -->

			<!-- ROW-3 OPEN -->
			<div class="row row-deck">
				<div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
					<div class="card">
						<div class="card-header border-bottom-0">
							<h3 class="card-title">Popular Courses</h3>
						</div>
						<div class="card-body p-0">
							<div class="table-responsive">
								<table class="table  mb-0 text-nowrap">
									<tbody>
										<tr>
											<td>
												<div class="software-cat">
													<img src="{{URL::asset('assets/images/pngs/0-2.png')}}" alt="img" class="ang-bg br-5">
												</div>
											</td>
											<td>
												<h6 class="mb-1 font-weight-semibold">AngularJs</h6>
												<small class="fs-12 text-muted mr-2"><i class="fa fa-calendar mr-1"></i>9 Months</small>
												<small class="fs-12 text-muted "><i class="fa fa-clock-o mr-1"></i>2 Hours</small>
											</td>
											<td class="text-center">
												<h6 class="mb-0 font-weight-bold">$34</h6>
												<span class="fs-12 text-yellow">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star-o"></i>
												</span>
											</td>
										</tr>
										<tr>
											<td>
												<div class="software-cat">
													<img src="{{URL::asset('assets/images/pngs/0-1.png')}}" alt="img" class="wd-bg br-5">
												</div>
											</td>
											<td>
												<h6 class="mb-1 font-weight-semibold">Wordpress</h6>
												<small class="fs-12 text-muted mr-2"><i class="fa fa-calendar mr-1"></i>3 Months</small>
												<small class="fs-12 text-muted "><i class="fa fa-clock-o mr-1"></i>1 Hours</small>
											</td>
											<td class="text-center">
												<h6 class="mb-0 font-weight-bold">$16</h6>
												<span class="fs-12 text-yellow">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star-o"></i>
													<i class="fa fa-star-o"></i>
												</span>
											</td>
										</tr>
										<tr>
											<td>
												<div class="software-cat">
													<img src="{{URL::asset('assets/images/pngs/0-3.png')}}" alt="img" class="re-bg br-5">
												</div>
											</td>
											<td>
												<h6 class="mb-1 font-weight-semibold">React</h6>
												<small class="fs-12 text-muted mr-2"><i class="fa fa-calendar mr-1"></i>4 Months</small>
												<small class="fs-12 text-muted "><i class="fa fa-clock-o mr-1"></i>4 Hours</small>
											</td>
											<td class="text-center">
												<h6 class="mb-0 font-weight-bold">$25</h6>
												<span class="fs-12 text-yellow">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star-o"></i>
													<i class="fa fa-star-o"></i>
												</span>
											</td>
										</tr>
										<tr>
											<td>
												<div class="software-cat">
													<img src="{{URL::asset('assets/images/pngs/0-4.png')}}" alt="img" class="vue-bg br-5">
												</div>
											</td>
											<td>
												<h6 class="mb-1 font-weight-semibold">Vuejs</h6>
												<small class="fs-12 text-muted mr-2"><i class="fa fa-calendar mr-1"></i>5 Months</small>
												<small class="fs-12 text-muted "><i class="fa fa-clock-o mr-1"></i>2 Hours</small>
											</td>
											<td class="text-center">
												<h6 class="mb-0 font-weight-bold">$18</h6>
												<span class="fs-12 text-yellow">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star-o"></i>
												</span>
											</td>
										</tr>
										<tr>
											<td>
												<div class="software-cat">
													<img src="{{URL::asset('assets/images/pngs/0-5.png')}}" alt="img" class="lar-bg br-5">
												</div>
											</td>
											<td>
												<h6 class="mb-1 font-weight-semibold">Laravel</h6>
												<small class="fs-12 text-muted mr-2"><i class="fa fa-calendar mr-1"></i>3 Months</small>
												<small class="fs-12 text-muted "><i class="fa fa-clock-o mr-1"></i>3 Hours</small>
											</td>
											<td class="text-center">
												<h6 class="mb-0 font-weight-bold">$22</h6>
												<span class="fs-12 text-yellow">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star-o"></i>
													<i class="fa fa-star-o"></i>
												</span>
											</td>
										</tr>
										<tr>
											<td>
												<div class="software-cat">
													<img src="{{URL::asset('assets/images/pngs/0-6.png')}}" alt="img" class="node-bg br-5">
												</div>
											</td>
											<td>
												<h6 class="mb-1 font-weight-semibold">Nodejs</h6>
												<small class="fs-12 text-muted mr-2"><i class="fa fa-calendar mr-1"></i>2 Months</small>
												<small class="fs-12 text-muted "><i class="fa fa-clock-o mr-1"></i>1 Hours</small>
											</td>
											<td class="text-center">
												<h6 class="mb-0 font-weight-bold">$28</h6>
												<span class="fs-12 text-yellow">
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star"></i>
													<i class="fa fa-star-o"></i>
												</span>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Students Overview</h3>
						</div>
						<div class="card-body">
							<div class="mb-5">
								<p class="mb-2">Good<span class="float-right"><b>80%</b></span></p>
								<div class="progress h-2">
									<div class="progress-bar bg-primary w-80 " role="progressbar"></div>
								</div>
							</div>
							<div class="mb-5">
								<p class="mb-2">Satisfied<span class="float-right"><b>75%</b></span></p>
								<div class="progress h-2">
									<div class="progress-bar bg-secondary w-75 " role="progressbar"></div>
								</div>
							</div>
							<div class="mb-5">
								<p class="mb-2">Excellent<span class="float-right"><b>72%</b></span></p>
								<div class="progress h-2">
									<div class="progress-bar bg-secondary1 w-70 " role="progressbar"></div>
								</div>
							</div>
							<div class="mb-5">
								<p class="mb-2">Average<span class="float-right"><b>65%</b></span></p>
								<div class="progress h-2">
									<div class="progress-bar bg-warning w-65" role="progressbar"></div>
								</div>
							</div>
							<div class="mb-5">
								<p class="mb-2">Below Average<span class="float-right"><b>50%</b></span></p>
								<div class="progress h-2">
									<div class="progress-bar bg-info w-50 " role="progressbar"></div>
								</div>
							</div>
							<div class="mb-0">
								<p class="mb-2">Unsatisfied<span class="float-right"><b>40%</b></span></p>
								<div class="progress h-2">
									<div class="progress-bar bg-orange w-40 " role="progressbar"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Top 5 Instructors</h3>
						</div>
						<div class="card-body p-3">
							<div class="border p-0">
								<div class="list d-flex align-items-center border-bottom p-3">
									<span class="avatar avatar-md brround cover-image" data-image-src="{{URL::asset('assets/images/users/1.jpg')}}"></span>
									<div class="wrapper w-100 ml-3">
										<div class="mb-0 d-flex mt-2">
											<div>
												<h5 class="mb-0">Lillian Blake</h5>
												<p class="mb-0 fs-13 text-muted">Web Designer</p>
											</div>
											<div class="ml-auto">
												<p class="fs-13 text-muted mb-0">Daily:2 hours</p>
											</div>
										</div>
									</div>
								</div>
								<div class="list d-flex align-items-center border-bottom p-3">
									<span class="avatar avatar-md brround cover-image" data-image-src="{{URL::asset('assets/images/users/10.jpg')}}"></span>
									<div class="wrapper w-100 ml-3 mt-2">
										<div class="mb-0 d-flex">
											<div>
												<h5 class="mb-0 font-weight-normal">Tim Gray</h5>
												<p class="mb-0 fs-13 text-muted">Data Science</p>
											</div>
											<div class="ml-auto">
												<p class="fs-13 text-muted mb-0">Daily:1 hours</p>
											</div>
										</div>
									</div>
								</div>
								<div class="list d-flex align-items-center border-bottom p-3">
									<span class="avatar avatar-md brround cover-image" data-image-src="{{URL::asset('assets/images/users/3.jpg')}}"></span>
									<div class="wrapper w-100 ml-3">
										<div class="mb-0 d-flex mt-2">
											<div>
												<h5 class="mb-0 font-weight-normal">Rose Nash</h5>
												<p class="mb-0 fs-13 text-muted">Law</p>
											</div>
											<div class="ml-auto">
												<p class="fs-13 text-muted mb-0">Daily:3 hours</p>
											</div>
										</div>
									</div>
								</div>
								<div class="list d-flex align-items-center  border-bottom p-3">
									<span class="avatar avatar-md brround cover-image" data-image-src="{{URL::asset('assets/images/users/9.jpg')}}"></span>
									<div class="wrapper w-100 ml-3">
										<div class="mb-0 d-flex mt-2">
											<div>
												<h5 class="mb-0 font-weight-normal">Justin Parr</h5>
												<p class="mb-0 fs-13 text-muted">Photography</p>
											</div>
											<div class="ml-auto">
												<p class="fs-13 text-muted mb-0">Daily:2 hours</p>
											</div>
										</div>
									</div>
								</div>
								<div class="list d-flex align-items-center  p-3">
									<span class="avatar avatar-md brround cover-image" data-image-src="{{URL::asset('assets/images/users/8.jpg')}}"></span>
									<div class="wrapper w-100 ml-3">
										<div class="mb-0 d-flex mt-2">
											<div>
												<h5 class="mb-0 font-weight-normal">Justin Parr</h5>
												<p class="mb-0 fs-13 text-muted">Digital Marketing</p>
											</div>
											<div class="ml-auto">
												<p class="fs-13 text-muted mb-0">Daily:3 hours</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ROW-3 CLOSED -->

			<!-- ROW-4 OPEN -->
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Courses Overview</h3>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered table-hover mb-0 text-nowrap">
									<thead>
										<tr>
											<th>Course Name</th>
											<th>Faculty Name</th>
											<th>Duration</th>
											<th>Amount</th>
											<th>Course Type</th>
											<th>Status</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>HTML Classes</td>
											<td>Vanessa</td>
											<td>3 Months</td>
											<td class="font-weight-semibold fs-15">$89</td>
											<td>Online</td>
											<td>
												<a class="btn btn-success btn-sm text-white mb-1" data-toggle="tooltip" data-original-title="View">Active</a>
											</td>
										</tr>
										<tr>
											<td>3D Animation Trainig</td>
											<td>Rutherford</td>
											<td>6 Months</td>
											<td class="font-weight-semibold fs-15">$14,276</td>
											<td>Online</td>
											<td>
												<a class="btn btn-primary btn-sm text-white mb-1" data-toggle="tooltip" data-original-title="View">Closed</a>
											</td>
										</tr>
										<tr>
											<td>Digital Marketing</td>
											<td>Elizabeth</td>
											<td>4 Months</td>
											<td class="font-weight-semibold fs-15">$25,000</td>
											<td>Offline</td>
											<td>
												<a class="btn btn-success btn-sm text-white mb-1" data-toggle="tooltip" data-original-title="View">Active</a>
											</td>
										</tr>
										<tr>
											<td>Guitar classes</td>
											<td>Anthony</td>
											<td>3 Months</td>
											<td class="font-weight-semibold fs-15">$50.00</td>
											<td>Online</td>
											<td>
												<a class="btn btn-danger btn-sm text-white mb-1" data-toggle="tooltip" data-original-title="View">Expired</a>
											</td>
										</tr>
										<tr>
											<td>Beautician Classes</td>
											<td>Lambert</td>
											<td>2 Months</td>
											<td class="font-weight-semibold fs-15">$99.99</td>
											<td>Offline</td>
											<td>
												<a class="btn btn-primary btn-sm text-white mb-1" data-toggle="tooltip" data-original-title="View">Closed</a>
											</td>
										</tr>
										<tr>
											<td>PhotoShop Designing</td>
											<td>Lilly</td>
											<td>6 Months</td>
											<td class="font-weight-semibold fs-15">$145</td>
											<td>Offline</td>
											<td>
												<a class="btn btn-success btn-sm text-white mb-1" data-toggle="tooltip" data-original-title="View">Active</a>
											</td>
										</tr>
										<tr>
											<td>3D Animation Trainig</td>
											<td>Marry cott</td>
											<td>8 Months</td>
											<td class="font-weight-semibold fs-15">$378</td>
											<td>Online</td>
											<td>
												<a class="btn btn-success btn-sm text-white mb-1" data-toggle="tooltip" data-original-title="View">Active</a>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ROW-4 CLOSED -->
@endsection
@section('js')
		<!-- INTERNAL CHARTJS CHART JS -->
		<script src="{{URL::asset('assets/plugins/chart/Chart.bundle.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/chart/utils.js')}}"></script>

		<!-- INTERNAL PIETY CHART JS -->
		<script src="{{URL::asset('assets/plugins/peitychart/jquery.peity.min.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/peitychart/peitychart.init.js')}}"></script>

		<!-- INTERNAL MORRIS CHART JS -->
		<script src="{{URL::asset('assets/plugins/morris/morris.js')}}"></script>
		<script src="{{URL::asset('assets/plugins/morris/raphael-min.js')}}"></script>
		<!-- INTERNAL APEXCHART JS -->
		<script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>

		<!--INTERNAL INDEX JS-->
		<script src="{{URL::asset('assets/js/index4.js')}}"></script>
@endsection
