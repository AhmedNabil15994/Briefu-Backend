<?php

namespace Modules\User\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Catalog\Transformers\Api\NationalityResource;
use Modules\Subscription\Transformers\Api\ClientSubscriptionDataResource;

class UserResource extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'country_code' => $this->country_code ?? '965',
            'mobile' => $this->mobile,
            'image' => $this->image ? url($this->image) : asset('uploads/users/user.png'),
            'nationality' => new NationalityResource($this->nationality),
            'has_subscription' => $this->activeSubscription ? true : false,
            'current_subscription' => new ClientSubscriptionDataResource($this->activeSubscription),
            'cv' => $this->profileCv ? new UserCvResource($this) : null
        ];
    }
}
