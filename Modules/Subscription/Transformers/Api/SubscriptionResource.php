<?php

namespace Modules\Subscription\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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
            'sub_title' => $this->sub_title,
            'price' => $this->price,
            'is_free' => $this->is_free,
            'days_number' => $this->days_number,
            'per' => $this->ber_numbers.' / '.optional($this->berType)->title,
            'tier' => new TeirResource($this->tier),
            'possibilities' => PossibilityResource::collection($this->possibilities()->whereNotNull('title')->get())
        ];
    }
}
