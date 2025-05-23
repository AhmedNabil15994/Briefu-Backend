<?php

namespace Modules\Subscription\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\JsonResource;

class BerTypeResource extends JsonResource
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
            'days_number' => $this->days_number,
            'status'        => $this->status,
            'created_at'    => date('d-m-Y' , strtotime($this->created_at)),
        ];
    }
}
