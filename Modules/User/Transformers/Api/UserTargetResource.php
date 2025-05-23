<?php

namespace Modules\User\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Company\Transformers\Api\CompanyResource;

class UserTargetResource extends Resource
{
    public function toArray($request)
    {
        return [
           // 'id'                 => $this->id,
           'value'              => $this->translate(locale())->title,
           'value_id'           => $this->id,
           'attribute'          => $this->attribute->translate(locale())->title,
           'attribute_id'       => $this->attribute->id,
       ];
    }
}
