<?php

namespace Modules\User\Transformers\Api;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Company\Transformers\Api\CompanyResource;

class UserCertificationResource extends Resource
{
    public function toArray($request)
    {
        return [
           'id'                 => $this->id,
           'certificat'         => $this->certificat,
           'address'            => $this->address,
        //    'from'               => $this->from,
        //    'hours'              => $this->hours,
       ];
    }
}
