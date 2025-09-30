@component('mail::message')
# Hello {{ $user->name }}

Your OTP for login is:

@component('mail::panel')
{{ $otp }}
@endcomponent

This OTP will expire in 5 minutes.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
