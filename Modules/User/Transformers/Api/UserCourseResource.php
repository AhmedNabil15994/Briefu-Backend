<?php

namespace Modules\User\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Company\Transformers\Api\CompanyResource;

class UserCourseResource extends Resource
{
    public function toArray($request)
    {
        return [
           'course'             => $this->translate(locale())->title,
           'course_id'          => $this->id,
       ];
    }
}
