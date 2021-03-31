@extends('layouts.master4')
@section('pageTitle', 'Forgot Password -')

@section('css')

<!-- INTERNAL SINGLE-PAGE CSS -->
<link href="{{URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content')

<!-- CONTAINER OPEN -->
<div class="container-login100">
    <div class="row">
        <div class="col col-login mx-auto">
            <form class="card" onsubmit="return false;">

                <div class="card-body p-6">
                    <h3 class="text-center card-title">Forgot password</h3>
                    <div class="form-group">
                        <input type="text" name="" id="userEmail" placeholder="Email" class="form-control">
                    </div> <span class="focus-input100"></span>
                    <div class="form-footer">
                        <a href="javascript:;" class="btn btn-primary btn-block" id="f_send"
                            onclick="sendPassword()">Send</a>
                        <span id="load-fPwd"></span>

                    </div>
                    <div class="text-center text-muted mt-3 ">
                        Forget it, <a href="{{url('/' . $page='login')}}">send me back</a> to the sign in screen.
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- CONTAINER CLOSED -->
@endsection
@section('js')
<!-- INPUT MASK JS-->
<script src="{{URL::asset('assets/js/cn-forgotPassword.js')}}"></script>

<script src="{{URL::asset('assets/plugins/input-mask/jquery.mask.min.js')}}"></script>
@endsection