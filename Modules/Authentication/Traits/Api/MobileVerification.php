<?php

namespace Modules\Authentication\Traits\Api;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Modules\Transaction\Services\SMS\SMS;
use Modules\User\Entities\UserMobileVerification;

trait MobileVerification
{
    /**
     * @return int
     */
    public function getOtp()
    {
        return rand(1000, 9999);
    }

    /**
     * @return string
     */
    public function getOtpExpiredDate(): string
    {
        return Carbon::now()->addMinutes(5);
    }

    /**
     * @param $expired_date
     * @return string
     */
    public function checkOtpExpiredDate($expired_date): string
    {
        $check = (Carbon::now() > $expired_date) ? false : true;
        return $check;
    }

    /**
     * @param $mobile
     * @return false|mixed
     */
    public function CheckMobileVerification($mobile)
    {
        $verificationRecord = $this->CheckMobileVerificationExists($mobile);

        if ($verificationRecord && $this->checkOtpExpiredDate($verificationRecord->otp_expired_date)) {
            return $verificationRecord;
        }
        return false;
    }

    /**
     * @param $mobile
     * @return mixed
     */
    public function CheckMobileVerificationExists($mobile)
    {
        return UserMobileVerification::where('mobile', $mobile)->first();
    }

    /**
     * @param $mobile
     * @return mixed
     */
    public function createOrUpdateMobileVerification($mobile)
    {
        return (new UserMobileVerification)->updateOrCreate([
            'mobile' => $mobile,
        ], [
            'otp' => $this->getOtp(),
            'otp_expired_date' => $this->getOtpExpiredDate(),
        ]);
    }

    /**
     * @param $mobile
     * @return mixed
     */
    public function deleteMobileCheck($mobile)
    {
        return (new UserMobileVerification)->where('mobile', $mobile)->delete();
    }

    /**
     * @param $request
     */
    public function sendVerificationOtp($mobile)
    {
        $verificationRecord = $this->createOrUpdateMobileVerification($mobile);
        $message = __('authentication::api.otp.messages.your_otp_is') . $verificationRecord->otp;

        if (App::environment('production'))
            (new SMS())->send($verificationRecord->mobile, $message);

        return $verificationRecord->otp;
    }

}
