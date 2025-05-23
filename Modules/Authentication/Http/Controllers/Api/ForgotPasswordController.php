<?php

namespace Modules\Authentication\Http\Controllers\Api;

use Modules\Authentication\Notifications\Api\ResetPasswordNotification;
use Modules\Transaction\Services\SMS\SMS;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Authentication\Http\Requests\Api\ForgetPasswordRequest;
use Modules\Authentication\Repositories\Api\AuthenticationRepository as Authentication;

class ForgotPasswordController extends ApiController
{
    private $sms;

    function __construct(Authentication $auth)
    {
        $this->sms = new SMS;
        $this->auth = $auth;
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $token = $this->auth->createToken($request);
        $user = $token['user'];

        $user->notify((new ResetPasswordNotification($token))->locale(locale()));
        return $this->response([], __('authentication::api.forget_password.messages.success'));
    }
}
