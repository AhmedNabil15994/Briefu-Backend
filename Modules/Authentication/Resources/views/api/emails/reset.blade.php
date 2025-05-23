@component('mail::message')

  {{-- <center>{!! $greeting !!}{{asset(substr(setting('logo'), 1))}}</center> --}}
  <h2> <center>@if(setting('mail_header'))<img src="{{asset(setting('mail_header'))}}" width="100"><br><br>@endif {{ __('authentication::api.reset.mail.header') }} </center> </h2>

  @component('mail::button', [
    'url' => url(route('frontend.password.reset',$token['token']). '?email=' . $token['user']->email)
  ])

    {{ __('authentication::api.reset.mail.button_content') }}

  @endcomponent

@endcomponent
