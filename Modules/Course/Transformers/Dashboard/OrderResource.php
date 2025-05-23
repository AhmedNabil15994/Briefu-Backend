<?php

namespace Modules\Course\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\Resource;

class OrderResource extends Resource
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
           'id'            => $this->id,
           'title'         => optional($this->course->translate(locale()))->title,
           'company'       => optional($this->course)->company ? $this->course->company->translate(locale())->title : ' -- ',
           'user'          => optional($this->user)->name,
           'mobile'          => optional($this->user)->country_code.optional($this->user)->mobile,
           'deleted_at'    => $this->deleted_at,
           'created_at'    => date('d-m-Y' , strtotime($this->created_at)),
       ];
    }
}
