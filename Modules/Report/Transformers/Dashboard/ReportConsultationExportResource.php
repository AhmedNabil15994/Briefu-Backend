<?php

namespace Modules\Report\Transformers\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;

class ReportConsultationExportResource extends Resource
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
            'subscription_id' => optional($this->subscription)->title,
            'client_id' => optional($this->user)->name,
            'client_mobile' => '+'.optional($this->user)->country_code.' '.optional($this->user)->mobile,
            'client_email' => optional($this->user)->email,
            'country' => optional(optional(optional($this->user)->profileCv)->country)->title,
            'ask_contact' => $this->ask_contact == 1 ? __('report::dashboard.reports.datatable.yes') : __('report::dashboard.reports.datatable.no'),
            'admin_contact' =>$this->admin_contact == 1 ? __('report::dashboard.reports.datatable.yes') : __('report::dashboard.reports.datatable.no'),
            'consultation' => $this->consultation,
            'deleted_at' => $this->deleted_at,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
