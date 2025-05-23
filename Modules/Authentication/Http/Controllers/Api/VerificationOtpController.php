<?php

namespace Modules\Authentication\Http\Controllers\Api;

use Illuminate\Support\Facades\App;
use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Authentication\Http\Requests\Api\ResendOtpRequest;
use Modules\Authentication\Traits\Api\MobileVerification;

class VerificationOtpController extends ApiController
{
    use MobileVerification;

    public function resendOtp(ResendOtpRequest $request)
    {
        $otp = $this->sendVerificationOtp($request->country_code.$request->mobile);

        if (App::environment('production'))
            return $this->response([], __('authentication::api.otp.messages.we_are_send_otp_to_verify_your_phone'));
        else
            return $this->response(['otp' => $otp], __('authentication::api.otp.messages.we_are_send_otp_to_verify_your_phone'));
    }
}
