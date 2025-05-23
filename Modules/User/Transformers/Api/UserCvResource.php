<?php

namespace Modules\User\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Company\Transformers\Api\CompanyResource;

class UserCvResource extends Resource
{
    public function toArray($request)
    {
        return [
            'is_special' => $this->is_special,
            'profile' => new UserProfileResource($this->profileCv),
            // 'profile_video' => optional($this->videoCv)->video_status ? new UserProfileVideoResource($this->videoCv) : null,
            'profile_video' => $this->activeSubscription && $this->videoCv ? new UserProfileVideoResource($this->videoCv) : null,
            'experiences' => UserExperienceResource::collection($this->experiences()->orderBy('from','desc')->get()),
            'certificattions' => UserCertificationResource::collection($this->certifications()->orderBy('order','asc')->get()),
            'target' => UserTargetResource::collection($this->target),
            'qualificatios' => UserQualificationResource::collection($this->qualifications),
            'courses' => UserCourseResource::collection($this->courses()->latest()->get()),
        ];
    }
}
