<?php

namespace Modules\Course\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'id'            => $this->id,
           'title'         => $this->translate(locale())->title,
           'price'         => $this->price,
           'image'         => $this->image ? url($this->image) : null,
           'description'   => htmlView($this->translate(locale())->description),
       ];
    }
}
