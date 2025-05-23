<?php

namespace Modules\Job\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;

class JobResource extends Resource
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
            'image' => asset(optional($this->company)->image),
            'company' => optional(optional($this->company)->translate(locale()))->title,
            'title' => optional($this->translate(locale()))->title,
            'status' => $this->status,
            'subscription_access' => $this->subscription_access,
            'is_favorite' => auth('api')->check() && $this->favorites()->where('user_favorites.user_id' , auth('api')->user()->id)->first() ? true : false,
            'description' => $this->translate(locale())->description,
            'attributes' => JobAttributeResource::collection($this->attributes),
            'submmited_date' => $this->whenLoaded('userCV', function () {
                return date('d-m-Y', strtotime($this->userCV->created_at));
            }),
            'cv_status' => $this->whenLoaded('userCV', function () {
                return $this->userCV->status;
            }),
        ];
    }
}
