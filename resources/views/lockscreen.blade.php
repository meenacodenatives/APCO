@extends('layouts.master4')
@section('css')
<!-- INTERNAL SINGLE-PAGE CSS -->
<link href="{{URL::asset('assets/plugins/single-page/css/main.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content')
            <!-- CONTAINER OPEN -->
            <div class="container-login100">
                <div class="wrap-login100 p-5">
                    <form class="login100-form validate-form ">
                        <div class="text-center mb-4">
                            <img src="{{URL::asset('assets/images/users/10.jpg')}}" alt="lockscreen image" class="avatar avatar-xxl brround mb-2">
                            <h4>Jacob Fisher</h4>
                        </div>
                        <div class="wrap-input100 validate-input" data-validate="Password is required">
                            <input class="input100" type="password" name="pass" placeholder="Password">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                    <g fill="none">
                                        <path d="M0 0h24v24H0V0z" />
                                        <path d="M0 0h24v24H0V0z" opacity=".87" />
                                    </g>
                                    <path d="M6 20h12V10H6v10zm6-7c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z" opacity=".3" />
                                    <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z" />
                                </svg>
                            </span>
                        </div>
                        <div class="container-login100-form-btn">
                            <a href="{{url('/' . $page='index')}}" class="login100-form-btn btn-primary">
                                Unlock
                            </a>
                        </div>
                        <div class="text-center pt-2">
                            <span class="txt1">
                                I Forgot
                            </span>
                            <a class="txt2" href="{{url('/' . $page='forgot')}}">
                                Give me Hint
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- CONTAINER CLOSED -->
@endsection
@section('js')
@endsection