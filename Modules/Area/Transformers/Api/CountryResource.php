<?php

namespace Modules\Area\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;

class CountryResource extends Resource
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
           'id'            => $this->id,
           'title'         => optional($this->translate(locale()))->title,
       ];
    }
}
