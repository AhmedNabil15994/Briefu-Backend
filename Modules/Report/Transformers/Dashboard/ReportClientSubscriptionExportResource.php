<?php

namespace Modules\Report\Transformers\Dashboard;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;

class ReportClientSubscriptionExportResource extends Resource
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
            'client_id' => optional($this->client)->name,
            'client_mobile' => '+'.optional($this->client)->country_code.' '.optional($this->client)->mobile,
            'client_email' => optional($this->client)->email,
            'amount' => $this->amount,
            'is_free' => $this->is_free,
            'consultations_status' => $this->consultation ? __('report::dashboard.reports.datatable.yes') : __('report::dashboard.reports.datatable.no'),
            'paid' => __("report::dashboard.reports.form.paid.{$this->paid}"),
            'action_type' => __("report::dashboard.reports.form.action_type.{$this->action_type}"),
            'expired_date' => Carbon::parse($this->expired_date)->toDateString(),
            'deleted_at' => $this->deleted_at,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}
