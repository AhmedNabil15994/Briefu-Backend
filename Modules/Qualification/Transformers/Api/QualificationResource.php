<?php

namespace Modules\Qualification\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class QualificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'id'            => $this->id,
           'title'         => $this->translate(locale())->title,
       ];
    }
}
