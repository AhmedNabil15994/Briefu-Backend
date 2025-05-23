<?php

namespace Modules\Company\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Category\Transformers\Api\CategoryResource;

class CompanyResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'id'            => $this->id,
           'image'         => url($this->image),
           'title'         => $this->translate(locale())->title,
       ];
    }
}
