<?php

namespace Modules\User\Repositories\Api;

use Illuminate\Support\Str;
use Modules\User\Entities\ObtainCredential;
use Modules\User\Traits\VdocipherIntegration;

class VideoIntegrationRepository
{
    use VdocipherIntegration;

    private $credential;

    function __construct(ObtainCredential $credential)
    {
        $this->credential = $credential;
    }


    public function createObtainCredentials()
    {
        try {
            $credential = $this->credential->where('status', 'created')->first();
            if (!$credential || $credential->video) :

                $response = $this->ObtainCredentials(Str::random(20).'.mp4');

                if ($response->getData()->status && optional($response->getData()->data)->clientPayload != null):
                    $credential = $this->credential->create([
                        'client_payload' => json_encode($response->getData()->data->clientPayload),
                        'api_video_id' => $response->getData()->data->videoId,
                    ]);
                else:
                    return false;
                endif;
            endif;
            return $credential;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function uploadVideo($credential, $file)
    {
        try {
            return $this->upload($credential, $file);

        } catch (\Exception $e) {
            throw $e;
        }
    }

    static function buildVideo($id)
    {
        $response = self::getOtp($id)->getData()->data;
        if (!empty($response->otp)) {
            $otp = $response->otp;
            $playbackInfo = $response->playbackInfo;
        } else {

            $otp = '';
            $playbackInfo = '';
        }

        return view('user::layouts.render-video', compact('otp', 'playbackInfo'))->render();
    }

    static function apiBuildVideo($id)
    {
        $response = self::getOtp($id)->getData()->data;
        if (!empty($response->otp)) {
            $otp = $response->otp;
            $playbackInfo = $response->playbackInfo;
        } else {

            $otp = '';
            $playbackInfo = '';
        }

        return [
            'otp' => $otp,
            'playbackInfo' => $playbackInfo,
        ];
    }


    static function checkVideoStatus($id)
    {
        $response = self::getVideoStatus($id)->getData()->data;
        return isset($response->status) ? $response->status : null;
    }


    public function deleteVideo($id)
    {
        $this->delete($id)->getData()->data;
    }

}
