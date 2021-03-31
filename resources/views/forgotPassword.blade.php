@component('mail::message')
# Dear {{$forgotPwdDetails['user_name']}} 
{{$forgotPwdDetails['message1']}}
<br>
@component('mail::button', ['url' => $forgotPwdDetails['message']])
Change Password
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent