@extends('layouts.master4')
@section('css')
<!-- INTERNAL SINGLE-PAGE CSS -->
<link href="{{URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content')
<!-- CONTAINER OPEN -->
<div class="container-login100">
    <div class="wrap-login100 p-6">
        <form class="login100-form validate-form" onsubmit="return false">
            <span class="login100-form-title">
                Login
            </span>

            <div class="col-md-12">
                <div class="form-group">
                    <input type="text" name="lemail" id="lemail" placeholder="Email" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="lpassword" id="lpassword" placeholder="Password">
                </div>
            </div>

            <div class="lbtn text-right pt-1">
                    <p class="mb-0"><a href="{{url('/' . $page='forgot-password')}}" class="text-primary ml-1">Forgot Password?</a></p>
            </div>
            <div class="container-login100-form-btn">
                <a href="javascript:;" onclick="login()" class="lbtn login100-form-btn btn-primary">
                    Login
                </a>
                <span id="load-login"></span>
            </div>
            <!--<div class="text-center pt-3">
                    <p class="text-dark mb-0">Not a member?<a href="{{url('/' . $page='register')}}" class="text-primary ml-1">Sign UP now</a></p>
            </div>
            <div class=" flex-c-m text-center mt-3">
                    <p>Or</p>
                    <div class="social-icons">
                            <ul>
                                    <li><a class="btn  btn-social btn-block btn-google"><i class="fa fa-google-plus"></i> Sign up with Google</a></li>
                                    <li><a class="btn  btn-social btn-block btn-facebook mt-2"><i class="fa fa-facebook"></i> Sign in with Facebook</a></li>
                            </ul>
                    </div>
            </div>-->
        </form>
    </div>
</div>
<!-- CONTAINER CLOSED -->
@endsection
@section('js')
@endsection
