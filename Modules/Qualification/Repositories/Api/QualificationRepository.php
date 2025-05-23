<?php

namespace Modules\Qualification\Repositories\Api;

use Modules\Qualification\Entities\Qualification;

class QualificationRepository
{
    function __construct(Qualification $qualification)
    {
        $this->qualification   = $qualification;
    }

    public function getAllActivePaginate($order = 'id', $sort = 'desc')
    {
        $qualifications = $this->qualification->active()->orderBy($order, $sort)->get();
        return $qualifications;
    }

    public function findById($id)
    {
        $qualification = $this->qualification->active()->where('id',$id)->first();
        return $qualification;
    }
}
