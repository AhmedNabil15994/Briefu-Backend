<?php

namespace Modules\Category\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
