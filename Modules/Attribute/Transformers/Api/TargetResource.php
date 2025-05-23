<?php

namespace Modules\Attribute\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class TargetResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                 => $this->id,
            'image'              => url($this->image),
            'title'              => $this->translate(locale())->title,
            'attribute_values'   => AttributeValueResource::collection($this->values),
       ];
    }
}
