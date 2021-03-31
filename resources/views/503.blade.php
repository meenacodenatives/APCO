@extends('layouts.master2')
@section('css')
@endsection
@section('content')
			<!-- PAGE -->
			<div class="page page-h">
				<div class="page-content z-index-10">
					<div class="container text-center">
						<div class="row">
							<div class="col-lg-6 col-xl-6 col-md-6 d-block mx-auto">
								<div class="">
									<div class="">
										<div class="display-1 t mb-5">503</div>
										<h1 class="h2   mb-3">Service Unavailable</h1>
										<p class="h4 font-weight-normal mb-7 leading-normal">Looks like we're having some server issues...</p>
										<a class="btn btn-primary" href="{{url('/' . $page='index')}}">
											Back To Home
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End PAGE -->
@endsection
@section('js')
@endsection