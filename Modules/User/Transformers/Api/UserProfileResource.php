<?php

namespace Modules\User\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Company\Transformers\Api\CompanyResource;

class UserProfileResource extends Resource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'b_day' => $this->b_day,
            'cv_pdf' => $this->cv_pdf ? asset($this->cv_pdf) : null,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'country_id' => optional($this->country)->id,
            'country_name' => optional(optional($this->country)->translate(locale()))->title,
            'state_id' => optional($this->state)->id,
            'state' => optional(optional($this->state)->translate(locale()))->title,
            'qualification' => optional(optional($this->qualification)->translate(locale()))->title,
            'qualification_id' => $this->qualification_id,
            'gender_key' => $this->gender,
            'gender' => $this->gender_trans,
            'marital_status' => $this->marital_status,
            'major' => $this->major,
            'faculty' => $this->faculty,
            'is_fresh_graduate' => $this->is_fresh_graduate ? true : false,
            'graduate_year' => $this->graduate_year
        ];
    }
}
