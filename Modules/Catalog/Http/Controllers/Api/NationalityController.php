<?php

namespace Modules\Catalog\Http\Controllers\Api;

use Modules\Apps\Http\Controllers\Api\ApiController;
use Modules\Catalog\Entities\Nationality;
use Modules\Catalog\Transformers\Api\NationalityResource;

class NationalityController extends ApiController
{
    public function index()
    {
        return NationalityResource::collection(Nationality::active()->get());
    }
}
