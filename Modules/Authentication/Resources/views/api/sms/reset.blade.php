{{ __('authentication::api.reset.sms.header') }}
{{ __('authentication::api.reset.sms.reset_url'),' : ' }}
{!! url(route('frontend.password.reset',$token['token']). '?email=' . $token['user']->email) !!}

