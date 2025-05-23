<?php

namespace Modules\Subscription\Transformers\Dashboard;

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
            'price' => $this->price,
            'status' => $this->status,
            'is_free' => $this->is_free,
            'subscriptions' => $this->subscriptions()->count(),
            'ber_numbers' => $this->ber_numbers.' / '.optional($this->berType)->title,
        ];
    }
}
