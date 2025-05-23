<?php

namespace Modules\Subscription\Transformers\Api;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientSubscriptionDataResource extends JsonResource
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
            'expired_date' => Carbon::parse($this->expired_date)->toDateTimeString(),
            'is_expired' => Carbon::parse($this->expired_date) < Carbon::now(),
            'title' => $this->title,
            'amount' => $this->amount,
            'is_free' => $this->is_free,
            'is_apple_tier' => $this->is_apple_tier,
            'payment_status' => $this->paid,
            'action_type' => $this->action_type,
            'has_user_cv_video_access' => $this->has_user_cv_video_access,
            'has_pro_job_access' => $this->has_job_access,
            'has_ask_consultation' => $this->has_ask_consultation,
            'possibilities' => PossibilityResource::collection($this->possibilities()->whereNotNull('title')->get())
        ];
    }
}
