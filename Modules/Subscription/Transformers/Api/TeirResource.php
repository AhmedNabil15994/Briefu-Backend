<?php

namespace Modules\Subscription\Transformers\Api;

use  Illuminate\Http\Resources\Json\JsonResource;

class TeirResource extends JsonResource
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
            "id"            => $this->tier_id,
            "price"          => "$this->price $",
        ];
    }
}
