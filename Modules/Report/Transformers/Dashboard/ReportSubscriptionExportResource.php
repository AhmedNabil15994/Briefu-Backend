<?php

namespace Modules\Report\Transformers\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;

class ReportSubscriptionExportResource extends Resource
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
            'company' => optional(optional($this->company)->translate(locale()))->title,
            'package' => optional(optional($this->package)->translate(locale()))->title,
            'price' => $this->price,
            'date_from' => Carbon::parse($this->date_from)->toDateString(),
            'date_to' => Carbon::parse($this->date_to)->toDateString(),
            'deleted_at' => $this->deleted_at,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
