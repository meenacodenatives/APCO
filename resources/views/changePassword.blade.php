@component('mail::message')
# Dear {{$changePwdDetails['user_name']}} 
{{$changePwdDetails['message1']}}
<br>
{{$changePwdDetails['message2']}}
<br>
@component('mail::button', ['url' => $changePwdDetails['message']])
Login
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent