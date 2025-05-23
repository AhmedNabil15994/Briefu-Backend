<?php

namespace Modules\Company\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Company\Transformers\Api\CompanyResource;
use Modules\Company\Repositories\Api\CompanyRepository as Company;
use Modules\Apps\Http\Controllers\Api\ApiController;

class CompanyController extends ApiController
{
    function __construct(Company $companies)
    {
        $this->companies = $companies;
    }

    public function companies(Request $request)
    {
        $companies =  $this->companies->getAllCompanies($request);

        return CompanyResource::collection($companies);
    }
}
