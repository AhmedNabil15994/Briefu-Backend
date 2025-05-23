<?php

namespace Modules\Job\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;

class JobAttributeResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'icon'            => asset(optional($this->attribute)->image),
            'attribute'       => optional(optional($this->attribute)->translate(locale()))->title,
            'attribute_value' => optional($this->translate(locale()))->title,
       ];
    }
}
