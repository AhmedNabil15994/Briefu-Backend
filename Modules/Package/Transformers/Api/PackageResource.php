<?php

namespace Modules\Package\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
           'id'            => $this->id,
           'title'         => $this->translate(locale())->title,
           'is_free'         => $this->is_free,
       ];
    }
}
