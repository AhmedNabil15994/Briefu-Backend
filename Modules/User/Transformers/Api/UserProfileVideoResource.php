<?php

namespace Modules\User\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Storage;
use Modules\User\Repositories\Api\VideoIntegrationRepository;

class UserProfileVideoResource extends Resource
{

    public function toArray($request)
    {
        // $otp = $this->video_status == 'loaded' ? VideoIntegrationRepository::apiBuildVideo($this->video) : null;
        return [
            'id' => $this->id,
            // 'status' => $this->video_status,
            'status' => 'loaded',
            'video_api_id'  => $this->video,
            'video_url'  => Storage::disk('s3')->url($this->video),
            // 'otp' => $otp ? $otp['otp'] : '',
            // 'playbackInfo' => $otp ? $otp['playbackInfo'] : '',
            'otp' => '',
            'playbackInfo' => '',
        ];
    }
}
