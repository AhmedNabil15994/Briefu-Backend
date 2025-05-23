<?php

namespace Modules\Job\Transformers\Dashboard;

use Illuminate\Http\Resources\Json\Resource;

class CVSResource extends Resource
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
           'title'         => $this->job->translate(locale())->title,
           'company'       => $this->job->company->translate(locale())->title,
           'user'          => $this->user->name,
           'deleted_at'    => $this->deleted_at,
           'created_at'    => date('d-m-Y' , strtotime($this->created_at)),
       ];
    }
}
