<?php

namespace Modules\Report\Transformers\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;

class ReportUserResource extends Resource
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
            'subscription' => optional($this->subscription)->title,
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => '+'.$this->country_code.' '.$this->mobile,
            'country' => optional(optional($this->profileCv)->country)->title,
            'gender' => optional($this->profileCv)->gender_trans,
            'nationality_id' => optional($this->nationality)->title,
            'attributes' => $this->str_attrs,
            'deleted_at' => $this->deleted_at,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
