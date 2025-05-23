<?php

namespace Modules\User\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Company\Transformers\Api\CompanyResource;

class UserExperienceResource extends Resource
{
    public function toArray($request)
    {
        return [
           'id'                 => $this->id,
           'company'            => $this->company,
           'company_address'    => $this->company_address,
           'from'               => $this->from,
           'to'                 => $this->to,
           'position'           => $this->position,
        ];
    }
}
