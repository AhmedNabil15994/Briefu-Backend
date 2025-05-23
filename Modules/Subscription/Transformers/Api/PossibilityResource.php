<?php

namespace Modules\Subscription\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class PossibilityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status,
        ];
    }
}
