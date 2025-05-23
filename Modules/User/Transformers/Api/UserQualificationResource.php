<?php

namespace Modules\User\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Company\Transformers\Api\CompanyResource;

class UserQualificationResource extends Resource
{
    public function toArray($request)
    {
        return [
           'id'                 => $this->id,
           'title'              => $this->translate(locale())->title,
       ];
    }
}
