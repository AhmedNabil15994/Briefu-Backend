
<html lang="ar" dir="rtl">
@section('title',__('authentication::dashboard.login.routes.reset_password'))
<link rel="stylesheet" href="{{ url('admin/assets/pages/css/login.min.css') }}">
@include('apps::dashboard.layouts._head_ltr')
<style>
    .help-block{
        color:red
    }
</style>
<body class="login">
<div class="content">

    <form class="login-form" method="POST" action="{{ route('frontend.password.update') }}">

        {{ csrf_field() }}

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <h3 class="text-dark-gray font-18 font-weight-600"> {{ __('authentication::dashboard.login.routes.reset_password') }}</h3>
        <div class="form-group{{$errors->has('password') ? 'has-error' : ''}}">
            <input type="password" class="form-control form-control-solid placeholder-no-fix" placeholder=" {{ __('authentication::dashboard.login.form.password') }}" name="password">
            @if ($errors->has('password'))
                <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
            @endif
        </div>

        <div class="form-group{{$errors->has('password_confirmation') ? 'has-error' : ''}}">
            <input type="password" class="form-control form-control-solid placeholder-no-fix" placeholder="{{ __('authentication::dashboard.login.form.password_confirmation') }}" name="password_confirmation">
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
            @endif
        </div>

        <button type="submit"  class="btn green uppercase">
            <span class="py-1 d-inline-block">   
                {{ __('authentication::dashboard.login.form.btn.reset_password') }}
            </span>
        </button>
    </form>
</div>
@include('apps::dashboard.layouts._footer')
@include('apps::dashboard.layouts._jquery')
</body>
</html>