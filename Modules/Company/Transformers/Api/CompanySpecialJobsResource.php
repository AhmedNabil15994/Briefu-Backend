<?php

namespace Modules\Company\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Job\Transformers\Api\JobResource;

class CompanySpecialJobsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'id'                         => $this->id,
           'image'                      => url($this->image),
           'title'                      => $this->translate(locale())->title,
           'special_job_for_company'    => new JobResource($this->specialJobs),
       ];
    }
}
