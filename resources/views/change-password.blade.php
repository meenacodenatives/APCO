@extends('layouts.master4')
@section('pageTitle', 'Change Password -')

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
                    <h3 class="text-center card-title">Change password
					<input type="hidden" name="" id="secret_key" value="<?php echo $data;?>" class="form-control">
					</h3>
                    <div class="col-md-12">
                        <div class="form-group">
						<label class="form-label"> New Password</label>
                        <input type="password" name="" id="newPwd" placeholder="New Password" class="form-control">
                        </div>
                        <div class="form-group">
						<label class="form-label"> Confirm Password</label>
                            <input type="password" class="form-control" name="Confirm Password" id="confirmPwd"
                                placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="form-footer">
                        <a href="javascript:;" class="btn btn-primary btn-block" id="c_send"
                            onclick="sendNewPassword()">Send</a>
                        <span id="load-cPwd"></span>

                    </div>
                    <!-- <div class="text-center text-muted mt-3 ">
                        Forget it, <a href="{{url('/' . $page='login')}}">send me back</a> to the sign in screen.
                    </div> -->
                </div>
            </form>
        </div>
    </div>
</div>
<!-- CONTAINER CLOSED -->
@endsection
@section('js')
<!-- INPUT MASK JS-->
<script src="{{URL::asset('assets/js/cn-changePassword.js')}}"></script>

<script src="{{URL::asset('assets/plugins/input-mask/jquery.mask.min.js')}}"></script>
@endsection