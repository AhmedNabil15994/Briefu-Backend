<?php

namespace Modules\Qualification\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Qualification\Transformers\Api\QualificationResource;
use Modules\Qualification\Repositories\Api\QualificationRepository as Qualification;
use Modules\Apps\Http\Controllers\Api\ApiController;

class QualificationController extends ApiController
{

    function __construct(Qualification $qualification)
    {
        $this->qualification = $qualification;
    }

    public function qualifications()
    {
        $qualifications =  $this->qualification->getAllActivePaginate();

        return QualificationResource::collection($qualifications);
    }

    public function qualification($id)
    {
        $qualification = $this->qualification->findById($id);

        if(!$qualification)
          return $this->response([]);

        return $this->response(new QualificationResource($qualification));
    }
}
